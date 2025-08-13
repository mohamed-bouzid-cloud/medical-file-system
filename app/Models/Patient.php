<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    // Tell Laravel the primary key is 'ipp' instead of 'id'
    protected $primaryKey = 'ipp';

    // 'ipp' is not auto-incrementing
    public $incrementing = false;

    // 'ipp' is a string
    protected $keyType = 'string';

    // Allow mass assignment
    protected $fillable = [
        'email',
        'password',
        'remember_token',
        'full_name',
        'phone',
        'dob',
        'gender',
        'ipp',
        'address',
    ];

    // Hide sensitive fields
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
}
