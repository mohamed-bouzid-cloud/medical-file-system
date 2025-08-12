<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PatientLogin extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (Auth::guard('patient')->attempt($credentials, true)) {
            return redirect()->route('patient.dashboard');
        }
        

        session()->flash('error', 'Invalid email or password');
    }

    public function render()
    {
        return view('livewire.patient-login');
    }
}
