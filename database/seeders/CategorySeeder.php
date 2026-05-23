<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Membuat data contoh kategori pilihan
        Category::create(['name' => 'Seminar', 'slug' => 'seminar']);
        Category::create(['name' => 'Workshop', 'slug' => 'workshop']);
        Category::create(['name' => 'Konser Musik', 'slug' => 'konser-musik']);
        Category::create(['name' => 'Lomba & Kompetisi', 'slug' => 'lomba-kompetisi']);
    }
}