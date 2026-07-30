<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak menumpuk/tersisa 1 data lama
        Partner::query()->delete();

        $partners = [
            [
                'name' => 'Midtrans',
                'logo_url' => 'https://asset.kompas.com/crops/O3xIe6_3a1K9d494y9NqZ916M2o=/0x0:1000x667/750x500/data/photo/2021/04/15/607817d1e0f06.png',
            ],
            [
                'name' => 'Google Cloud',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/5/51/Google_Cloud_logo.svg',
            ],
            [
                'name' => 'Microsoft',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg',
            ],
            [
                'name' => 'Laravel',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg',
            ],
            [
                'name' => 'Tailwind CSS',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg',
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}