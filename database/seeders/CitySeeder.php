<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Kota dan Spot Lokasinya
        $citiesData = [
            [
                'name' => 'Bandung',
                'details' => 'Kota Kembang, destinasi favorit untuk wisata alam, fashion, dan kuliner kreatif.',
                'price' => 250000.00,
                'spots' => ['Gedung Sate', 'Jalan Braga', 'Kawah Putih']
            ],
            [
                'name' => 'Jakarta',
                'details' => 'Metropolitan yang sibuk, pusat pemerintahan dengan sejarah kolonial dan kemewahan modern.',
                'price' => 450000.00,
                'spots' => ['Monumen Nasional', 'Kota Tua', 'Bundaran HI']
            ],
            [
                'name' => 'Yogyakarta',
                'details' => 'Jantung budaya Jawa, rumah bagi candi-candi megah dan seniman tradisional.',
                'price' => 150000.00,
                'spots' => ['Candi Prambanan', 'Jalan Malioboro', 'Taman Sari']
            ],
        ];

        foreach ($citiesData as $data) {
            $city = City::create([
                'id' => Str::uuid(),
                'name' => $data['name'],
                'details' => $data['details'],
                'price' => $data['price'],
            ]);

            $this->command->info("Seeding media untuk kota: {$city->name}...");

            for ($i = 1; $i <= 2; $i++) {
                try {
                    $url = "https://loremflickr.com/800/600/" . strtolower($data['name']) . ",city/all?random={$i}";

                    $city->addMediaFromUrl($url)
                        ->usingFileName(Str::slug($data['name']) . "-album-{$i}.jpg") // Nama file rapi di MinIO
                        ->toMediaCollection('albums'); // Otomatis masuk ke MinIO (karena default config)
                } catch (\Throwable $e) {
                    $this->command->warn(" - Gagal download album {$i}: " . $e->getMessage());
                }
            }

            // 3. Upload ke Collection 'photospots' (Foto Lokasi Spesifik)
            foreach ($data['spots'] as $index => $spotName) {
                try {
                    $keyword = strtolower(str_replace(' ', ',', $spotName));
                    $url = "https://loremflickr.com/800/600/{$keyword},landmark/all?random=" . ($index + 10);

                    $city->addMediaFromUrl($url)
                        ->usingFileName(Str::slug($spotName) . ".jpg")
                        ->withCustomProperties([
                            'location' => $spotName,
                            'photographer' => 'Sistem Seeder'
                        ])
                        ->toMediaCollection('photospots');

                    $this->command->info("   - Spot uploaded: {$spotName}");
                } catch (\Throwable $e) {
                    $this->command->warn("   - Gagal download spot {$spotName}: " . $e->getMessage());
                }
            }
        }
    }
}
