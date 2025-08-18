<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'doctor' or 'patient'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // If doctor, link by id
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'id', 'id'); // user.id = doctor.id
    }

    // If patient, link by ipp
    public function patient()
    {
        return $this->hasOne(Patient::class, 'ipp', 'id'); // user.id = patient.ipp
    }
}
