<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AuthComponent;
use App\Livewire\PatientDashboard;
use App\Livewire\DoctorDashboard;

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Role-based login and signup (Livewire)
Route::get('/login/{role}', AuthComponent::class)
    ->name('login')
    ->where('role', 'patient|doctor');

Route::get('/signup/{role}', AuthComponent::class)
    ->name('signup')
    ->where('role', 'patient|doctor');

// Dashboards with auth + role middleware
Route::middleware(['auth'])->group(function () {

    // Patient dashboard
    Route::get('/patient-dashboard', PatientDashboard::class)
        ->name('patient.dashboard')
        ->middleware('check.role:patient');

    // Doctor dashboard
  Route::get('/doctor-dashboard', DoctorDashboard::class)
        ->name('doctor.dashboard')
        ->middleware('check.role:doctor');

    // Logout route handled by Livewire component
    Route::post('/logout', [AuthComponent::class, 'logout'])->name('logout');
});
Route::get('/test-write', function () {
    $path = storage_path('app/doctor_notes/test_write.txt');
    try {
        file_put_contents($path, "hello world");
        return "File created successfully at $path";
    } catch (\Exception $e) {
        return "Write failed: " . $e->getMessage();
    }
});

use App\Livewire\TestUpload;

Route::get('/test-upload', TestUpload::class);
use App\Livewire\GeminiTest;

Route::get('/gemini-test', GeminiTest::class); // ✅ works with Laravel 9+ and Livewire 3
