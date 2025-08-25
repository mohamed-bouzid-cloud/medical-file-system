<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\DoctorServices;

// Add Models
use App\Models\Condition;
use App\Models\Allergy;
use App\Models\Medication;
use Carbon\Carbon;

class DoctorDashboard extends Component
{
    use WithFileUploads;

    public $selectedPatient = null;
    public $patientData = null;
    public $searchTerm = '';
    public $doctorNoteFile;
    public $processingNote = false;
    public $fileIsBound = false;
    public $apiResult = null;
    public $dicomFiles = [];
    public $certificatePassword;
    public $dicomDescription = ''; // ← add this


    private function service(): DoctorServices
    {
        return app(DoctorServices::class);
    }

    public function getAssignedPatientsProperty()
    {
        return $this->service()->getAssignedPatients(Auth::id());
    }

    public function selectPatient($patientIpp)
    {
        $this->selectedPatient = $patientIpp;
        $this->patientData = $this->service()->getPatientFullData($patientIpp);
    }

    public function updatedDoctorNoteFile()
    {
        $this->fileIsBound = !is_null($this->doctorNoteFile);
        $this->validate([
            'doctorNoteFile' => 'required|file|mimes:txt|max:10240',
        ]);
    }

    public function submitDoctorNote()
    {
        $this->validate([
            'doctorNoteFile' => 'required|file|mimes:txt|max:10240',
        ]);

        if (!$this->selectedPatient) {
            session()->flash('error', 'No patient chosen.');
            return;
        }

        $this->processingNote = true;

        try {
            // Save file
            $ext = $this->doctorNoteFile->getClientOriginalExtension() ?: 'txt';
            $patientSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $this->selectedPatient);
            $fileName = 'doctor_note_' . $patientSafe . '_' . uniqid() . '.' . $ext;

            $storedPath = Storage::disk('local')->putFileAs('doctor_notes', $this->doctorNoteFile, $fileName);
            $fullPath = Storage::disk('local')->path($storedPath);

            $fileContent = file_get_contents($fullPath);
            if (!$fileContent) {
                session()->flash('error', 'File is empty or unreadable.');
                $this->processingNote = false;
                return;
            }

            // Gemini API
            $apiKey = config('services.gemini.key');
            $model = 'gemini-1.5-flash-latest';
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            $promptText = "Extract conditions, allergies, and medications from this note as JSON with keys: 'conditions', 'allergies', 'medications'. Text: " . $fileContent;

            $response = Http::withHeaders(['Accept' => 'application/json'])->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $promptText]
                        ]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                Log::error('Gemini API Error: ' . $response->body());
                session()->flash('error', 'Failed to process doctor note with Gemini API.');
                $this->processingNote = false;
                return;
            }

            $responseData = $response->json();
            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$generatedText) {
                session()->flash('error', 'No content returned from AI.');
                $this->processingNote = false;
                return;
            }

            // Clean up ```json fences if present
            $cleanedText = preg_replace('/^```json|```$/m', '', trim($generatedText));

            $structuredData = json_decode($cleanedText, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error: ' . json_last_error_msg() . ' | Content: ' . $cleanedText);
                session()->flash('error', 'Failed to parse AI response.');
                $this->processingNote = false;
                return;
            }

            $ipp = $this->selectedPatient;

            // Conditions
            if (!empty($structuredData['conditions'])) {
                foreach ($structuredData['conditions'] as $cond) {
                    Condition::firstOrCreate(
                        ['ipp' => $ipp, 'condition_name' => (string) $cond],
                        ['diagnosed_date' => today(), 'notes' => 'Extracted from doctor note']
                    );
                }
            }
            
            // Allergies
            if (!empty($structuredData['allergies'])) {
                foreach ($structuredData['allergies'] as $allergy) {
                    Allergy::firstOrCreate(
                        ['ipp' => $ipp, 'allergen' => (string) $allergy],
                        ['reaction' => null, 'severity' => null]
                    );
                }
            }
            
            // Medications
            if (!empty($structuredData['medications'])) {
                foreach ($structuredData['medications'] as $med) {
                    Medication::firstOrCreate(
                        ['ipp' => $ipp, 'medication_name' => (string) $med],
                        ['dosage' => null, 'start_date' => today(), 'end_date' => null, 'notes' => 'Extracted from doctor note']
                    );
                }
            }
            
            // Refresh patientData for UI
            $this->patientData = $this->service()->getPatientFullData($ipp);
            $this->apiResult = $structuredData;

            session()->flash('success', 'Doctor note processed and saved to database!');

        } catch (\Throwable $e) {
            Log::error('submitDoctorNote error: '.$e->getMessage());
            session()->flash('error', 'Unexpected error: ' . $e->getMessage());
        } finally {
            $this->processingNote = false;
            $this->reset('doctorNoteFile');
            $this->fileIsBound = false;
        }
    }

    public function getFilteredPatientsProperty()
    {
        if (!$this->searchTerm) {
            return $this->assignedPatients;
        }
        return $this->assignedPatients->filter(fn($p) =>
            stripos($p->name, $this->searchTerm) !== false ||
            stripos($p->ipp, $this->searchTerm) !== false
        );
    }

    public function render()
{
    $upcomingAppointments = $this->service()
        ->getUpcomingAppointments(Auth::id())
        ->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'patient_name' => $appointment->patient->name ?? '',
                'date' => $appointment->appointment_date,
                'time' => $appointment->appointment_time,
            ];
        })
        ->toArray();

    return view('livewire.doctor-dashboard', [
        'filteredPatients' => $this->filteredPatients,
        'selectedPatient' => $this->selectedPatient,
        'patientData' => $this->patientData,
        'fileIsBound' => $this->fileIsBound,
        'apiResult' => $this->apiResult,
        'upcomingAppointments' => $upcomingAppointments,
    ]);
}
    public function uploadDicom()
        {
            $this->validate([
                'dicomFiles.*' => 'required|file|mimes:dcm,zip',
                'certificatePassword' => 'required|string',
            ]);
        
            try {
                // Upload the files
                $uploadedStudies = $this->service()->uploadDicomFiles(
                    $this->dicomFiles,
                    $this->selectedPatient,
                    Auth::id(),
                    $this->certificatePassword
                );
        
                // ✅ Save description for each uploaded study
                foreach ($uploadedStudies as $study) {
                    $study->description = $this->dicomDescription; // save from input
                    $study->save();
                }
        
                session()->flash('success', 'DICOM files uploaded and signed ✅');
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
            } finally {
                $this->dicomFiles = [];
                $this->certificatePassword = '';
                $this->dicomDescription = ''; // reset input
            }
        }
        
}