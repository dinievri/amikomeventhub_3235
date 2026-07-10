<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Mendaftarkan kolom database agar bisa disimpan menggunakan teknik Mass Assignment
    protected $fillable = [
        'category_id', 
        'title', 
        'description', 
        'date',
        'location', 
        'price', 
        'stock', 
        'poster_path'
    ];

    /**
     * Hubungan Relasi: Setiap Event terhubung ke satu Kategori
     */
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
}