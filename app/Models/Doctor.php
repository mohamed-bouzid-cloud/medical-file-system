<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
        'remember_token',
        'full_name',
        'phone',
        'specialization',
        'license_number',
        'experience',
        'clinic_address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
   
    
}
