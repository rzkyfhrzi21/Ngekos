<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Bonus};

class BonusSeeder extends Seeder
{
    public function run(): void
    {
        $bh1 = BoardingHouse::where('slug', 'kos-rzky-one')->first();

        Bonus::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'name' => 'Free WiFi'],
            ['description' => 'Internet 24 jam', 'image' => 'wifi.jpg']
        );
    }
}
