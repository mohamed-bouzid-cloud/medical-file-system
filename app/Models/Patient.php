<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $primaryKey = 'ipp'; // primary key is ipp
    public $incrementing = false;   // not auto-increment
    protected $keyType = 'string';  // if ipp is a string

    protected $fillable = [
        'ipp',
        'phone',
        'dob',
        'gender',
        'address',
        'user_id'
    ];

    // Link patient to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Add relationships
    public function conditions()
    {
        return $this->hasMany(Condition::class, 'ipp', 'ipp');
    }

    public function allergies()
    {
        return $this->hasMany(Allergy::class, 'ipp', 'ipp');
    }

    public function medications()
    {
        return $this->hasMany(Medication::class, 'ipp', 'ipp');
    }

    public function vitals()
    {
        return $this->hasOne(Vital::class, 'ipp', 'ipp');
    }
}
