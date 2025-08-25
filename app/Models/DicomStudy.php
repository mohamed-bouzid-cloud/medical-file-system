<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DicomStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_ipp',
        'doctor_id',
        'file_path',
        'study_uid',
        'description',
        'orthanc_id'
    ];

    // A study belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'ipp', 'ipp');
    }

    // A study belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // A study has one signature
    public function signature()
    {
        return $this->hasOne(DicomSignature::class, 'dicom_study_id');
    }
}
