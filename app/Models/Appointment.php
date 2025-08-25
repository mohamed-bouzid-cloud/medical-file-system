<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments'; // optional if table name is default

    // If your table doesn’t use default timestamps
    // public $timestamps = false;

    // Relationship to Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_ipp', 'ipp');
        // 'patient_ipp' = FK in appointments table
        // 'ipp' = PK in patients table
    }

    // Relationship to Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
        // assumes appointments table has 'doctor_id' FK
    }
}
