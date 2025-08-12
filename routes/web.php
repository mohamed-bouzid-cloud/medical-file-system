<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Livewire\AuthComponent;

// Default welcome page (patient welcome for now)
Route::get('/', function () {
    return view('welcome');
});

// Role-based login and signup routes
Route::get('/login/{role}', AuthComponent::class)
    ->name('login')
    ->where('role', 'patient|doctor');

Route::get('/signup/{role}', AuthComponent::class)
    ->name('signup')
    ->where('role', 'patient|doctor');

// Patient dashboard with middleware
Route::middleware(['check.role:patient'])->get('/patient-dashboard', function () {
    return view('patient-dashboard');
})->name('patient.dashboard');

// Doctor dashboard placeholder (commented for now)
// Route::middleware(['check.role:doctor'])->get('/doctor-dashboard', function () {
//     return view('doctor-dashboard');
// })->name('doctor.dashboard');

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
