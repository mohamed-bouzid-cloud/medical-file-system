<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Assignment;
use App\Models\Doctor;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Log::info('Fetching upcoming appointments for user ID: ' . $userId);

        $doctor = Doctor::where('user_id', $userId)->firstOrFail();
        Log::info('Doctor found: ', $doctor->toArray());

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->get();

        Log::info('Fetched appointments: ', $appointments->toArray());

        return $appointments->map(function ($appointment) {
            Log::info('Mapping appointment: ', $appointment->toArray());

            return [
                'id' => $appointment->id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'patient' => $appointment->patient ? [
                    'name' => $appointment->patient->name,
                ] : null,
            ];
        });
    }

    public function uploadDicomFiles($files, $patientIpp, $userId, $certificatePassword)
    {
        Log::info('Uploading DICOM files for patient IPP: ' . $patientIpp);

        $doctor = Doctor::where('user_id', $userId)->firstOrFail();
        Log::info('Doctor found for DICOM upload: ', $doctor->toArray());

        if (!\Hash::check($certificatePassword, $doctor->certificate_password)) {
            Log::error('Invalid certificate password for doctor ID: ' . $doctor->id);
            throw new \Exception('Invalid certificate password');
        }

        $uploadedStudies = [];

        foreach ($files as $file) {
            Log::info('Processing file: ' . $file->getClientOriginalName());

            $path = $file->store('dicom/' . $patientIpp, 'public');
            Log::info('File stored at path: ' . $path);

            $study = DicomStudy::create([
                'ipp' => $patientIpp,
                'doctor_id' => $doctor->id,
                'file_path' => $path,
            ]);
            Log::info('DICOM study created: ', $study->toArray());

            DicomSignature::create([
                'dicom_study_id' => $study->id,
                'doctor_id' => $doctor->id,
                'signature_hash' => hash('sha256', $file->get() . $doctor->id . now()->timestamp),
                'signed_at' => now(),
            ]);
            Log::info('DICOM signature created for study ID: ' . $study->id);

            $uploadedStudies[] = $study;
        }

        Log::info('Uploaded studies: ', $uploadedStudies);

        return $uploadedStudies;
    }
}
