<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\DicomStudy;
use App\Models\Allergy;
use App\Models\Medication;
use App\Models\Appointment;
use App\Models\LabResult;
use App\Models\Condition;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class PatientDashboard extends Component
{
    public $patient;
    public $allergies = [];
    public $medications = [];
    public $appointments = [];
    public $labResults = [];
    public $conditions = [];
    public $dicomStudies = [];
    public $selectedStudy; // for modal

    public function mount()
    {
        $account = Auth::user();

        if ($account->role !== 'patient') {
            abort(403, 'Unauthorized access.');
        }

        $this->patient = Patient::where('user_id', $account->id)->firstOrFail();
        $ipp = $this->patient->ipp;

        $this->allergies = Allergy::where('ipp', $ipp)->get();
        $this->medications = Medication::where('ipp', $ipp)->get();
        $this->appointments = Appointment::where('ipp', $ipp)->latest()->take(5)->get();
        $this->labResults = LabResult::where('ipp', $ipp)->latest()->take(5)->get();
        $this->conditions = Condition::where('ipp', $ipp)->get();
        $this->dicomStudies = DicomStudy::where('patient_ipp', $ipp)
        ->latest()
        ->get()
        ->map(function($study) {
            // Description
            $study->display_description = $study->description ?? 'No description';
    
            // Fetch signature + doctor + user
            $signature = DB::table('dicom_signatures')
                ->join('doctors', 'dicom_signatures.doctor_id', '=', 'doctors.id')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->where('dicom_study_id', $study->id)
                ->select('users.name as doctor_name', 'dicom_signatures.signed_at')
                ->first();
    
            if ($signature) {
                $study->display_signed_by = "Signed by Dr. {$signature->doctor_name}";
                $study->signed_at = $signature->signed_at;
            } else {
                $study->display_signed_by = "Not signed yet";
                $study->signed_at = null;
            }
    
            return $study;
        });   
    }

    public function openDicomStudy($studyId)
    {
        $this->selectedStudy = DicomStudy::findOrFail($studyId);

        // Check patient authorization
        if ($this->selectedStudy->patient_ipp !== $this->patient->ipp) {
            $this->emit('dicom-error', ['message' => 'Unauthorized study']);
            return;
        }

        // Check if Orthanc ID exists
        if (empty($this->selectedStudy->orthanc_id)) {
            $this->emit('dicom-error', ['message' => 'Missing Orthanc ID']);
            return;
        }

        // ✅ Emit URL to JS listener (Alpine will handle opening modal)
        $this->emit('open-dicom-viewer', [
            'url' => route('dicom.viewer', ['instanceID' => $this->selectedStudy->orthanc_id])
        ]);
    }
}
