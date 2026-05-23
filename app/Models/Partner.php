<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Pastikan 'logo_url' sudah terdaftar di dalam array fillable!
    protected $fillable = [
        'name',
        'logo_url',
    ];
}