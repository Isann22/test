<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\City;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Package (Konfigurasi durasi dan jumlah foto)
        $packagesData = [
            [
                'name' => '1 Hour Photo Shoot',
                'hour_duration' => 1,
                'downloadable_photos' => 20,
                'edited_photos' => 50,
                'multiplier' => 1.0, // Harga dasar (100%)
            ],
            [
                'name' => '2 Hours Photo Shoot',
                'hour_duration' => 2,
                'downloadable_photos' => 40,
                'edited_photos' => 100,
                'multiplier' => 1.8, // Diskon durasi (misal: lebih murah dibanding beli 1 jam x 2)
            ],
            [
                'name' => '3 Hours Photo Shoot',
                'hour_duration' => 3,
                'downloadable_photos' => 60,
                'edited_photos' => 150,
                'multiplier' => 2.5, // Lebih hemat untuk durasi panjang
            ],
        ];

        foreach ($packagesData as $data) {
            // 1. Buat data Package
            $package = Package::create([
                'name' => $data['name'],
                'hour_duration' => $data['hour_duration'],
                'downloadable_photos' => $data['downloadable_photos'],
                'edited_photos' => $data['edited_photos'],
            ]);

            $this->command->info("Seeding package: {$package->name}...");

            // 2. Ambil semua kota dari database
            $cities = City::all();

            foreach ($cities as $city) {

                $basePrice = $city->price;
                $finalPrice = $basePrice * $data['multiplier'];

                $city->packages()->attach($package->id, [
                    'price' => $finalPrice,
                ]);

                $formattedPrice = number_format($finalPrice, 0, ',', '.');
                $this->command->info("   - {$city->name}: Rp {$formattedPrice}");
            }
        }
    }
}
