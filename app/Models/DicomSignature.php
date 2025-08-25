<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DicomSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'dicom_study_id',
        'doctor_id',
        'signature_hash',
        'signed_at',
    ];
    protected $casts = [
        'signed_at' => 'datetime', // now Eloquent will return a Carbon instance
    ];
    

    // 🔗 Relations

    public function study()
    {
        return $this->belongsTo(DicomStudy::class, 'dicom_study_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
