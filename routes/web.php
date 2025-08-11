<?php

use Illuminate\Support\Facades\Route;

// This is the welcome page, which is fine.
Route::get('/', function () {
    return view('welcome');
});

// You don't need to explicitly "use" Livewire components in your routes file
// if you are using Livewire 3+ as a full-page component, since they are automatically discovered.
// However, it's good practice to declare them for clarity.

use App\Livewire\PatientDashboard;
use App\Http\Livewire\RegisterPatient;
use App\Http\Livewire\PatientLogin;


// Patient Registration Route
// This route will display the `auth.register` view.
// Livewire components for registration and login can be included within this view.
Route::view('/register', 'auth.register')->name('patient.register');


// Patient Login Route
// This route will display the `auth.login` view.
Route::view('/login', 'auth.login')->name('patient.login');


// Patient Dashboard Route
// This route is protected by the 'patient' guard.
// It will only be accessible to users who are authenticated as a 'patient'.
// The route name is 'patient.dashboard'.

Route::middleware(['auth:patient'])->get('/patient/dashboard', PatientDashboard::class)->name('patient.dashboard');

// Add this route for logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');