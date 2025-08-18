<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $table = 'vitals';
    protected $primaryKey = 'ipp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ipp',
        'heart_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'temperature'
    ];
}
