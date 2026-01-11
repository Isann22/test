<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moment;
use Illuminate\Support\Str;

class MomentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Moment
        $momentsData = [
            [
                'name' => 'Birthday',
                'details' => 'Rayakan momen ulang tahun spesial dengan foto-foto yang penuh kebahagiaan dan kenangan indah.',
            ],
            [
                'name' => 'Marriage',
                'details' => 'Abadikan hari pernikahan yang sakral dengan dokumentasi profesional penuh makna.',
            ],
            [
                'name' => 'Graduation',
                'details' => 'Momen kelulusan yang membanggakan, hasil dari kerja keras dan dedikasi selama bertahun-tahun.',
            ],
            [
                'name' => 'Family Gathering',
                'details' => 'Kumpul keluarga yang hangat, momen berharga bersama orang-orang tercinta.',
            ],
            [
                'name' => 'Engagement',
                'details' => 'Momen lamaran yang romantis, awal dari perjalanan cinta menuju pernikahan.',
            ],
        ];

        foreach ($momentsData as $data) {
            $moment = Moment::create([
                'id' => Str::uuid(),
                'name' => $data['name'],
                'details' => $data['details'],
            ]);

            $this->command->info("Seeding media untuk moment: {$moment->name}...");

            for ($i = 1; $i <= 2; $i++) {
                try {
                    $keyword = strtolower(str_replace(' ', ',', $data['name']));
                    $url = "https://loremflickr.com/800/600/{$keyword},nature/all?random={$i}";

                    $moment->addMediaFromUrl($url)
                        ->usingFileName(Str::slug($data['name']) . "-album-{$i}.jpg")
                        ->toMediaCollection('albums');

                    $this->command->info("   - Album {$i} uploaded untuk: {$data['name']}");
                } catch (\Throwable $e) {
                    $this->command->warn(" - Gagal download album {$i}: " . $e->getMessage());
                }
            }
        }
    }
}
