<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\LabResult;
use App\Models\Allergy;
use App\Models\Medication;
use App\Models\Condition;
use Livewire\Attributes\Layout;

// Tell Livewire to use the 'layouts.app' view as the main layout
#[Layout('layouts.app')] 
class PatientDashboard extends Component
{
    public $patient;
    public $allergies = [];
    public $medications = [];
    public $appointments = [];
    public $labResults = [];
    public $conditions = [];

    public function mount()
    {
        $account = Auth::user(); // Logged-in PatientAccount

        // Fetch the main patient record using IPP
        $this->patient = Patient::where('ipp', $account->ipp)->first();

        if ($this->patient) {
            // Use the same IPP value to fetch related records
            $ipp = $this->patient->ipp;

            $this->allergies = Allergy::where('ipp', $ipp)->get();
            $this->medications = Medication::where('ipp', $ipp)->get();
            $this->appointments = Appointment::where('ipp', $ipp)->latest()->take(5)->get();
            $this->labResults = LabResult::where('ipp', $ipp)->latest()->take(5)->get();
            $this->conditions = Condition::where('ipp', $ipp)->get();
        }
    }

    public function render()
    {
        return view('livewire.patient-dashboard');
    }
}
