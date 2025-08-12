<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // Tell Laravel the primary key is 'ipp' instead of 'id'
    protected $primaryKey = 'ipp';

    // If 'ipp' is NOT auto-incrementing integer, set this to false
    public $incrementing = false;

    // If 'ipp' is a string (likely), set the key type
    protected $keyType = 'string';

    // Allow mass assignment on these fields
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
