<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Room, RoomImage};

class RoomImageSeeder extends Seeder
{
    public function run(): void
    {
        $bh1 = BoardingHouse::where('slug', 'kos-rzky-one')->first();

        $room1 = Room::where('boarding_house_id', $bh1->id)->where('name', 'Kamar A1')->first();

        RoomImage::firstOrCreate(
            ['room_id' => $room1->id, 'image' => 'room1_1.jpg']
        );


    }
}
