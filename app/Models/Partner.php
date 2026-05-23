<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'partners';

    // Mengizinkan kolom ini untuk diisi data (Mass Assignment)
    protected $fillable = ['name', 'logo_url'];
}