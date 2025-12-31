<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cities = [
            [
                'name' => 'Bandung',
                'details' => 'Kota Kembang dengan suasana sejuk dan banyak destinasi wisata alam serta kuliner.',
                'price' => 250000.00
            ],
            [
                'name' => 'Yogyakarta',
                'details' => 'Kota budaya yang kaya akan sejarah, candi, dan kearifan lokal yang istimewa.',
                'price' => 150000.00
            ],
            [
                'name' => 'Denpasar',
                'details' => 'Gerbang utama menuju keindahan pulau dewata Bali dan pantai-pantainya.',
                'price' => 500000.00
            ],
            [
                'name' => 'Surabaya',
                'details' => 'Kota Pahlawan yang merupakan pusat bisnis dan perdagangan terbesar kedua di Indonesia.',
                'price' => 300000.00
            ],
            [
                'name' => 'Malang',
                'details' => 'Terkenal dengan apel, pegunungan yang indah, dan hawa yang dingin.',
                'price' => 200000.00
            ],
        ];

        foreach ($cities as $city) {
            City::create([
                'id' => Str::uuid(),
                'name' => $city['name'],
                'details' => $city['details'],
                'price' => $city['price'],
            ]);
        }
    }
}
