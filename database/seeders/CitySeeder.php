<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::firstOrCreate(
            ['slug' => 'bandar-lampung'],
            ['name' => 'Bandar Lampung', 'image' => 'city1.jpg']
        );
    }
}
