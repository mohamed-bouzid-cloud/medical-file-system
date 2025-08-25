<?php

namespace App\Services;

use App\Models\DicomStudy;
use App\Models\DicomSignature;
use App\Models\Patient;
use App\Models\Assignment;
use App\Models\Doctor;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 

class DoctorServices
{
    // Get patients assigned to a doctor
    public function getAssignedPatients($userId)
    {
        Log::info('Fetching assigned patients for user ID: ' . $userId);

        $doctor = Doctor::where('user_id', $userId)->first();
        if (!$doctor) {
            Log::warning('No doctor found for user ID: ' . $userId);
            return collect();
        }

        $assignedPatientIPPs = Assignment::where('doctor_id', $doctor->id)
                                          ->pluck('patient_ipp');
        Log::info('Assigned patient IPPs: ', $assignedPatientIPPs->toArray());

        $patients = Patient::whereIn('ipp', $assignedPatientIPPs)->get();
        Log::info('Fetched patients: ', $patients->toArray());

        return $patients;
    }

    // Get full patient data including conditions, allergies, medications
    public function getPatientFullData($patientIpp)
    {
        Log::info('Fetching full data for patient IPP: ' . $patientIpp);

        $patient = Patient::with(['conditions', 'allergies', 'medications'])
                          ->where('ipp', $patientIpp)
                          ->first();

        if (!$patient) {
            Log::warning('No patient found for IPP: ' . $patientIpp);
        } else {
            Log::info('Fetched patient data: ', $patient->toArray());
        }

        return $patient;
    }

    // Process a doctor's note with Gemini and store results
    public function processAndStoreNote($patientIpp, $noteContent)
    {
        Log::info('Processing doctor note for patient IPP: ' . $patientIpp);

        // Step 1: Call Gemini API
        $structuredData = $this->processNoteContent($noteContent);

        if (isset($structuredData['error'])) {
            Log::error('Error processing note: ' . $structuredData['error']);
            return $structuredData; // return error directly
        }

        Log::info('Structured data from Gemini API: ', $structuredData);

        // Step 2: Store conditions
        foreach ($structuredData['conditions'] ?? [] as $condition) {
            Log::info('Storing condition: ' . $condition);
            Condition::updateOrCreate(
                ['ipp' => $patientIpp, 'condition_name' => $condition],
                ['diagnosed_date' => now(), 'notes' => null]
            );
        }

        // Step 3: Store medications
        foreach ($structuredData['medications'] ?? [] as $medication) {
            Log::info('Storing medication: ' . $medication);
            Medication::updateOrCreate(
                ['ipp' => $patientIpp, 'medication_name' => $medication],
                ['dosage' => null, 'start_date' => now(), 'notes' => null]
            );
        }

        // Step 4: Store allergies
        foreach ($structuredData['allergies'] ?? [] as $allergy) {
            Log::info('Storing allergy: ' . $allergy);
            Allergy::updateOrCreate(
                ['ipp' => $patientIpp, 'allergen' => $allergy],
                ['reaction' => null, 'severity' => null]
            );
        }

        // Step 5: Return updated patient data
        $updatedPatientData = $this->getPatientFullData($patientIpp);
        Log::info('Updated patient data: ', $updatedPatientData->toArray());

        return $updatedPatientData;
    }

    // Private helper: Call Gemini API
    private function processNoteContent($noteContent)
    {
        Log::info('Calling Gemini API with note content.');

        $prompt = "Extract conditions, allergies, and medications from this doctor note and return as JSON with keys: 'conditions', 'allergies', 'medications'. Do not include any other text. Text: " . $noteContent;

        $apiKey = config('services.gemini.key');
        $model = 'gemini-1.5-flash-latest';
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                Log::error('Gemini API Error: ' . $response->body());
                return ['error' => 'Failed to process doctor note with Gemini API.'];
            }

            $responseData = $response->json();
            Log::info('Response from Gemini API: ', $responseData);

            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$generatedText) {
                Log::error('No content generated by the AI model.');
                return ['error' => 'No content generated by the AI model.'];
            }

            // Remove ```json fences if present
            $cleanedText = preg_replace('/^```json|```$/m', '', trim($generatedText));
            Log::info('Cleaned text from Gemini API: ' . $cleanedText);

            $structuredData = json_decode($cleanedText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error: ' . json_last_error_msg() . ' | Content: ' . $cleanedText);
                return ['error' => 'Failed to parse JSON response from Gemini.'];
            }

            return $structuredData;

        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            return ['error' => 'An unexpected error occurred while calling Gemini.'];
        }
    }

    // Fetch upcoming appointments
    public function getUpcomingAppointments($userId)
    {
        $doctor = Doctor::where('user_id', $userId)->firstOrFail();
    
        return Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->get()
            ->map(function ($appt) {
                $dt = \Carbon\Carbon::parse($appt->appointment_date);
                $appt->appointment_time = $dt->format('h:i A'); // add a virtual time property
                $appt->appointment_date = $dt->format('M j, Y'); // format date nicely
                return $appt;
            });
    }
    

    
    public function uploadDicomFiles(
        array $files,
        string $patientIpp,
        int $userId,
        string $certificatePassword,
        ?string $description = null
    ) {
        // Get doctor
        $doctor = Doctor::where('user_id', $userId)->firstOrFail();
    
        // Verify certificate password
        if (!\Hash::check($certificatePassword, $doctor->certificate_password)) {
            throw new \Exception('Invalid certificate password');
        }
    
        $uploadedStudies = [];
    
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $filename = uniqid('dicom_') . '_' . $originalName;
            $path = "dicom/{$patientIpp}/{$filename}";
    
            // Store file locally
            Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));
            Log::info("📂 Stored DICOM file: {$path}");
    
            // Attempt Orthanc upload
            $orthancId = null;
            try {
                $dicomData = file_get_contents($file->getRealPath());
    
                $response = Http::withHeaders([
                    'Content-Type' => 'application/dicom',
                    'Accept'       => 'application/json',
                ])->send('POST', 'http://localhost:8042/instances', [
                    'body' => $dicomData,
                ]);
    
                Log::info("📡 Orthanc upload response", [
                    'status' => $response->status(),
                    'body'   => $response->json(),
                ]);
    
                if ($response->successful()) {
                    $body = $response->json();
    
                    if (is_array($body) && isset($body['ID'])) {
                        $orthancId = $body['ID'];
                    } elseif (isset($body[0])) {
                        $orthancId = $body[0];
                    } else {
                        Log::warning("⚠️ Orthanc response missing ID", [
                            'file' => $filename,
                            'body' => $body,
                        ]);
                    }
                } else {
                    Log::error("❌ Orthanc rejected file {$filename}", [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("💥 Orthanc upload exception", [
                    'file'  => $filename,
                    'error' => $e->getMessage(),
                ]);
            }
    
            // Save in DB always
            $study = DicomStudy::create([
                'patient_ipp' => $patientIpp,
                'doctor_id'   => $doctor->id,
                'file_path'   => $path,
                'description' => $description,
                'study_uid'   => uniqid('study_'),
                'orthanc_id'  => $orthancId, // may be null if Orthanc fails
                'modality'    => 'OT',       // later: extract from DICOM
                'study_date'  => now()->toDateString(),
            ]);
    
            // Create digital signature
            DicomSignature::create([
                'dicom_study_id' => $study->id,
                'doctor_id'      => $doctor->id,
                'signature_hash' => hash('sha256', $path . $doctor->id . time()),
                'signed_at'      => now(),
            ]);
    
            $uploadedStudies[] = $study;
        }
    
        Log::info("✅ Uploaded DICOM studies for patient {$patientIpp}", [
            'count' => count($uploadedStudies),
        ]);
    
        return $uploadedStudies;
    }
    
    
    

}

    
    

