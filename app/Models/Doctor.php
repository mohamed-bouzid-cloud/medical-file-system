<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'id',              // same as user.id
        'phone',
        'specialization',
        'experience',
        'clinic_address',
        'user_id',
        'certificate_password', // hashed password for certificate verification
    ];

    public $incrementing = false; // because id comes from users table
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
