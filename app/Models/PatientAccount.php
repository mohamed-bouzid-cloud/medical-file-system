<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PatientAccount extends Authenticatable
{
    use Notifiable;

    protected $table = 'patient_accounts';

    protected $primaryKey = 'ipp';      // Tell Laravel the primary key column

    public $incrementing = false;       // ipp is not auto-increment integer

    protected $keyType = 'string';      // ipp is a string

    protected $fillable = [
        'ipp', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}


