<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Category, City};

class BoardingHouseSeeder extends Seeder
{
    public function run(): void
    {
        $city1 = City::where('slug', 'bandar-lampung')->first();


        $cat1 = Category::where('slug', 'kos-putra')->first();


        BoardingHouse::firstOrCreate(
            ['slug' => 'kos-rzky-one'],
            [
                'name' => 'Kos Rzky One',
                'thumbnail' => 'kos1.jpg',
                'city_id' => $city1->id,
                'category_id' => $cat1->id,
                'description' => 'Kos nyaman dekat kampus.',
                'price' => 800000,
                'address' => 'Jl. Zainal Abidin Pagar Alam',
            ]
        );
    }
}
