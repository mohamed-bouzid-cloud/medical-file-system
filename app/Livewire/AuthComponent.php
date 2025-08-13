<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\Doctor;

class AuthComponent extends Component
{
    public $email, $password, $confirm_password;
    public $full_name, $dob, $gender, $phone, $address, $ipp;
    public $specialization, $license_number, $experience, $clinic_address;
    public $login_error = null; // holds login error messages
    public $remember = false;
    public $role;   // patient or doctor
    public $action; // login or signup

    public function mount($role)
    {
        if (!in_array($role, ['patient', 'doctor'])) {
            abort(404);
        }

        $this->role = $role;
        $routeName = request()->route()->getName();
        $this->action = $routeName === 'signup' ? 'signup' : 'login';
    }


    
   // ...
// app/Livewire/AuthComponent.php

// ... (other properties and methods)

public function login()
{
    $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $guard = $this->role; // "patient" or "doctor"

    if (Auth::guard($guard)->attempt([
        'email' => $this->email,
        'password' => $this->password
    ], $this->remember)) {
        session()->regenerate();
        return redirect()->to("/{$this->role}-dashboard");
    }

    $this->addError('email', 'The provided credentials do not match our records.');
    $this->password = '';
    
}






    public function register()
    {
        $model = $this->role === 'doctor' ? Doctor::class : Patient::class;
    
        $rules = [
            'email' => 'required|email|unique:' . strtolower($this->role) . 's,email',
            'password' => 'required|min:6|same:confirm_password',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ];
    
        if ($this->role === 'patient') {
            $rules = array_merge($rules, [
                'dob' => 'required|date',
                'gender' => 'required|string',
                'ipp' => 'required|string|max:20|unique:patients,ipp',
                'address' => 'nullable|string|max:255',
            ]);
        }
    
        if ($this->role === 'doctor') {
            $rules = array_merge($rules, [
                'specialization' => 'required|string|max:100',
                'license_number' => 'required|string|max:50|unique:doctors,license_number',
                'experience' => 'required|numeric|min:0',
                'clinic_address' => 'nullable|string|max:255',
            ]);
        }
    
        $this->validate($rules);
    
        $data = [
            'email' => $this->email,
            'password' => Hash::make($this->password), // This is the corrected line
            'full_name' => $this->full_name,
            'phone' => $this->phone,
        ];
    
        if ($this->role === 'patient') {
            $data['dob'] = $this->dob;
            $data['gender'] = $this->gender;
            $data['ipp'] = $this->ipp;
            $data['address'] = $this->address;
        } else {
            $data['specialization'] = $this->specialization;
            $data['license_number'] = $this->license_number;
            $data['experience'] = $this->experience;
            $data['clinic_address'] = $this->clinic_address;
        }
    
        $model::create($data);
    
        session()->flash('success', ucfirst($this->role) . ' registered! Please login.');
        return redirect()->to("/login/{$this->role}");
    }
    public function logout()
    {
        Auth::logout();
        session()->forget(['auth_role']);
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.auth-component');
    }
}
