<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Allergy extends Model
{
    use HasFactory;

    protected $table = 'allergies';

    protected $fillable = [
        'ipp',
        'allergen',
        'reaction',
        'severity',
    ];
}
