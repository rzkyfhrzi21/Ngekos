<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
            BoardingHouseSeeder::class,
            RoomSeeder::class,
            BonusSeeder::class,
            TestimonialSeeder::class,
            TransactionSeeder::class,
            RoomImageSeeder::class,
        ]);
    }
}
