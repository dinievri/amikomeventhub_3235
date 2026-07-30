<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Pastikan 'logo_url' ada di dalam array ini!
    protected $fillable = ['name', 'logo_url'];
}