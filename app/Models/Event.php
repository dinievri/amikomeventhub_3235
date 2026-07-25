<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review; // <-- Perbaikan: Impor model Review
use App\Models\Organization;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'organization_id',
        'title',
        'description',
        'price',
        'location',
        'event_date',
    ];

    // Relasi ke Organization
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Relasi ke Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper untuk menghitung rata-rata rating
    public function averageRating()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}