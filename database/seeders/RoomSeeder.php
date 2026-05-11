<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Room};

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $bh1 = BoardingHouse::where('slug', 'kos-rzky-one')->first();

        Room::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'name' => 'Kamar A1'],
            [
                'room_type' => 'Standard',
                'square_feet' => 12,
                'capacity' => 1,
                'price_per_month' => 800000,
                'is_available' => 1,
            ]
        );

    }
}
