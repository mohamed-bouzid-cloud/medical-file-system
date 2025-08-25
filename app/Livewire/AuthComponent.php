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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;


class AuthComponent extends Component
{
    public $email, $password, $confirm_password;
    public $full_name, $dob, $gender, $phone, $address, $ipp;
    public $specialization, $certificate_password, $experience, $clinic_address;
    public $login_error = null;
    public $remember = false;
    public $role;   // 'patient' or 'doctor'
    public $searchTerm = '';
    public $action; // 'login', 'signup', 'forgot', 'reset'
    public $reset_token; // for password reset
    

    public function mount($role = null, $token = null)
{
    // Validate role if provided
    if ($role && !in_array($role, ['patient', 'doctor'])) abort(404);
    $this->role = $role;

    // Determine action based on route
    $routeName = request()->route()->getName();
    if ($routeName === 'signup') {
        $this->action = 'signup';
    } elseif ($routeName === 'login') {
        $this->action = 'login';
    } elseif ($routeName === 'forgot-password') {
        $this->action = 'forgot';
    } elseif ($routeName === 'reset-password' && $token) {
        $this->resetForm($token); // sets $reset_token and $action = 'reset'
    }
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
            $user = User::where('email', $this->email)->first();
    
            if (!$user) {
                // Email doesn't exist → highlight email
                $this->addError('email', 'Email not found.');
                return;
            }
    
            if (!Hash::check($this->password, $user->password)) {
                // Wrong password → highlight password
                $this->addError('password', 'Password is incorrect.');
                return;
            }
    
            if ($user->role !== $this->role) {
                Auth::logout();
                $this->addError('email', "This account is registered as {$user->role}, not {$this->role}.");
                return;
            }
    
            // Success
            Auth::login($user, $this->remember);
            session(['auth_role' => $this->role]);
            session()->regenerate();
    
            return redirect()->intended("/{$this->role}-dashboard");
    
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage(), ['email' => $this->email]);
            $this->addError('email', 'Something went wrong. Please try again later.');
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
            $rules = [
                'specialization' => 'required|string|max:100',
                'certificate_password' => 'required|string|max:50|unique:doctors,certificate_password',
                'experience' => 'required|numeric|min:0',
                'clinic_address' => 'nullable|string|max:255',
            ];
            
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
                'certificate_password' => Hash::make($this->certificate_password),
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
    public function sendResetLink()
{
    $this->validate(['email' => 'required|email']);

    $user = User::where('email', $this->email)->first();
    if (!$user) {
        $this->addError('email', 'No user found with this email.');
        return;
    }

    $user->reset_token = Str::random(64);
    $user->reset_expiry = now()->addHours(2);
    $user->save();

    $resetUrl = URL::to("/reset-password/{$user->reset_token}");

    try {
        Mail::raw(
            "Hello {$user->name},\n\nClick the link below to reset your password:\n{$resetUrl}\n\nThis link will expire in 2 hours.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Password Reset Link');
            }
        );

        session()->flash('success', 'Password reset link sent to your email!');
    } catch (\Exception $e) {
        Log::error('Failed to send reset email: '.$e->getMessage(), ['email' => $user->email]);
        $this->addError('email', 'Unable to send email. Please try again later.');
    }
}

    
public function resetPassword()
{
    $this->validate([
        'reset_token' => 'required',
        'password' => 'required|min:6|same:confirm_password',
    ]);

    $user = User::where('reset_token', $this->reset_token)
                ->where('reset_expiry', '>', now())
                ->first();

    if (!$user) {
        $this->addError('reset_token', 'Invalid or expired token.');
        return;
    }

    $user->password = Hash::make($this->password);
    $user->reset_token = null;
    $user->reset_expiry = null;
    $user->save();

    session()->flash('success', 'Password updated! Please login.');
    $this->action = 'login';
}
// ---------------------------
// Show Reset Password Form
// ---------------------------
public function resetForm($token)
{
    $this->reset_token = $token;
    $this->action = 'reset';

    // return the same view as render(), but with current action
    return view('livewire.auth-component', [
        'currentAction' => $this->action
    ]);
}

}
