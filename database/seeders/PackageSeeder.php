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
        // Data Package
        $packagesData = [
            [
                'name' => '1 Hour Photo Shoot',
                'hour_duration' => 1,
                'downloadable_photos' => 20,
                'edited_photos' => 50,
            ],
            [
                'name' => '2 Hours Photo Shoot',
                'hour_duration' => 2,
                'downloadable_photos' => 40,
                'edited_photos' => 100,
            ],
            [
                'name' => '3 Hours Photo Shoot',
                'hour_duration' => 3,
                'downloadable_photos' => 60,
                'edited_photos' => 150,
            ],
        ];

        // Harga per Kota
        $cityPricing = [
            'Jakarta' => [169, 299, 399],
            'Bandung' => [149, 269, 359],
            'Yogyakarta' => [129, 229, 319],
        ];

        foreach ($packagesData as $index => $data) {
            $package = Package::create([
                'name' => $data['name'],
                'hour_duration' => $data['hour_duration'],
                'downloadable_photos' => $data['downloadable_photos'],
                'edited_photos' => $data['edited_photos'],
            ]);

            $this->command->info("Seeding package: {$package->name}...");

            // Attach ke semua kota dengan harga berbeda
            $cities = City::all();
            foreach ($cities as $city) {
                $prices = $cityPricing[$city->name] ?? [150, 250, 350];
                $price = $prices[$index] ?? $prices[0];

                $city->packages()->attach($package->id, [
                    'price' => $price,
                ]);

                $this->command->info("   - {$city->name}: \${$price}");
            }
        }
    }
}
