<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Tambahkan import User untuk seeder Admin
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SEED AKUN ADMIN PERDANA (Sesuai Modul Pertemuan 8)
        User::create([
            'name'     => 'Admin Amikom',
            'email'    => 'admin@amikom.ac.id',
            'password' => bcrypt('password'), // Password dienkripsi
            'role'     => 'admin' // Pastikan kolom role ada di file migration users Anda
        ]);

        // 2. SEED KATEGORI
        $catWorkshop = Category::create(['name' => 'Workshop', 'slug' => Str::slug('Workshop')]);
        $catSeminar = Category::create(['name' => 'Seminar', 'slug' => Str::slug('Seminar')]);
        $catCompetition = Category::create(['name' => 'Competition', 'slug' => Str::slug('Competition')]);

        // 3. SEED EVENT (Semua kolom wajib diisi)
        $events = [
            ['title' => 'UI/UX Masterclass', 'cat' => $catWorkshop->id, 'loc' => 'Gedung Amikom Room 4.2'],
            ['title' => 'Laravel Backend Intensive', 'cat' => $catWorkshop->id, 'loc' => 'Zoom Meeting'],
            ['title' => 'Future of AI Seminar', 'cat' => $catSeminar->id, 'loc' => 'Cinema Amikom'],
            ['title' => 'Digital Marketing Strategy', 'cat' => $catSeminar->id, 'loc' => 'Aula BSC Amikom'],
            ['title' => 'E-Sport U-Champ', 'cat' => $catCompetition->id, 'loc' => 'Amikom Food Court'],
            ['title' => 'Nasional Hackathon', 'cat' => $catCompetition->id, 'loc' => 'Laboratorium Terpadu'],
        ];

        foreach ($events as $index => $e) {
            Event::create([
                'title'       => $e['title'],
                'category_id' => $e['cat'],
                'description' => 'Deskripsi untuk kegiatan ' . $e['title'],
                'date'        => Carbon::now()->addDays($index + 5), // Tanggal event diatur otomatis ke depan
                'location'    => $e['loc'],
                'price'       => 50000, 
                'stock'       => 100,  
            ]);
        }
    }
}