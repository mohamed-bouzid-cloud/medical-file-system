<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthComponent extends Component
{
    public $email, $password, $confirm_password;
    public $full_name, $dob, $gender, $phone, $address, $ipp;
    public $specialization, $license_number, $experience, $clinic_address;
    public $login_error = null;
    public $remember = false;
    public $role;   // 'patient' or 'doctor'
    public $action; // 'login' or 'signup'
    public $searchTerm = '';


    public function mount($role)
    {
        if (!in_array($role, ['patient', 'doctor'])) abort(404);

        $this->role = $role;
        $this->action = request()->route()->getName() === 'signup' ? 'signup' : 'login';
    }

    // ---------------------------
    // Login Method
    // ---------------------------
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (!Auth::attempt(
                ['email' => $this->email, 'password' => $this->password],
                $this->remember
            )) {
                $this->addError('login_error', 'Invalid credentials.');
                return;
            }

            $user = Auth::user();
            if ($user->role !== $this->role) {
                Auth::logout();
                $this->addError('login_error', "This account is not a {$this->role}.");
                return;
            }

            // Optional: regenerate remember token
            if ($this->remember) {
                $user->remember_token = Str::random(60);
                $user->save();
            }

            session(['auth_role' => $this->role]);
            session()->regenerate();

            return redirect()->intended("/{$this->role}-dashboard");

        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage(), ['email' => $this->email]);
            $this->addError('login_error', 'An unexpected error occurred.');
        }
    }

    // ---------------------------
    // Registration Method
    // ---------------------------
    public function register()
    {
        // Validate common fields
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirm_password',
            'phone' => 'required|string|max:20',
        ];

        if ($this->role === 'patient') {
            $rules = array_merge($rules, [
                'dob' => 'required|date',
                'gender' => 'required|string',
                'ipp' => 'required|string|max:20|unique:patients,ipp',
                'address' => 'nullable|string|max:255',
            ]);
        } else { // doctor
            $rules = array_merge($rules, [
                'specialization' => 'required|string|max:100',
                'license_number' => 'required|string|max:50|unique:doctors,license_number',
                'experience' => 'required|numeric|min:0',
                'clinic_address' => 'nullable|string|max:255',
            ]);
        }

        $this->validate($rules);

        // Create the user (auto-increment ID)
        $user = User::create([
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'remember_token' => Str::random(60),
        ]);

        // Create profile linked via user_id
        if ($this->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'ipp' => $this->ipp,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
        } else { // doctor
            Doctor::create([
                'user_id' => $user->id,
                'phone' => $this->phone,
                'specialization' => $this->specialization,
                'license_number' => $this->license_number,
                'experience' => $this->experience,
                'clinic_address' => $this->clinic_address,
            ]);
        }

        session()->flash('success', ucfirst($this->role) . ' registered! Please login.');
        return redirect()->to("/login/{$this->role}");
    }

    // ---------------------------
    // Logout
    // ---------------------------
    public function logout()
    {
        $role = session('auth_role');
        if ($role) {
            $user = Auth::user();
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
            Auth::logout();
            session()->forget('auth_role');
        }
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.auth-component');
    }
}
