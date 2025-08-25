<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AuthComponent;
use App\Livewire\PatientDashboard;
use App\Livewire\DoctorDashboard;
use App\Models\DicomStudy;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DicomViewerController;

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

// Quick test write
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

Route::get('/reset-password/{token}', AuthComponent::class)
     ->name('reset-password');

     // ===============================
     // DICOM ROUTES
     // ===============================
     
     // Simple preview page with <img> (PNG from Orthanc)
     Route::get('/dicom/open/{instanceID}', [DicomViewerController::class, 'open'])
         ->name('dicom.open');
     
     // Returns rendered PNG (Orthanc proxy)
     Route::get('/dicom/rendered/{instanceID}', [DicomViewerController::class, 'rendered'])
         ->name('dicom.rendered');
     
     // Full interactive DWV/Cornerstone viewer
     Route::get('/dicom/viewer/{instanceID}', [DicomViewerController::class, 'viewer'])
         ->name('dicom.viewer');
     
     // Raw DICOM file (for download or JS viewer use)
     Route::get('/dicom/file/{instanceID}', [DicomViewerController::class, 'file'])
         ->name('dicom.file');
     