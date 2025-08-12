<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\PatientAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterPatient extends Component
{
    public $ipp;
    public $email;
    public $password;
    public $password_confirmation;

    public function register()
    {
        $this->validate([
            'ipp' => 'required|exists:patients,ipp',
            'email' => 'required|email|unique:patient_accounts,email',
            'password' => 'required|min:6|same:password_confirmation',
        ]);

        $account = PatientAccount::create([
            'ipp' => $this->ipp,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Log in only if PatientAccount extends Authenticatable
        if ($account instanceof \Illuminate\Contracts\Auth\Authenticatable) {
            Auth::login($account, true);
            return redirect()->route('patient.dashboard');
        }

        session()->flash('message', 'Account created successfully! You can now log in.');
        return redirect()->route('patient.login');
    }

    public function render()
    {
        // FIXED the view name to match Livewire default
        return view('livewire.register-patient');
    }
}
