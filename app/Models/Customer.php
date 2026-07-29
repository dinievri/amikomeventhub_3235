<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Impor Authenticatable
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable // <-- Ubah "extends Model" menjadi "extends Authenticatable"
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'phone',
        'avatar',
    ];
}