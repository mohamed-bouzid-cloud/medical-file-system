<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condition extends Model
{
    use HasFactory;

    protected $table = 'conditions';

    protected $fillable = [
        'ipp',
        'condition_name',
        'diagnosed_date',
        'notes',
    ];

    protected $casts = [
        'diagnosed_date' => 'date',
    ];
}
