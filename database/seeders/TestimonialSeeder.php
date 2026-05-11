<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Testimonial};

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $bh1 = BoardingHouse::where('slug', 'kos-rzky-one')->first();

        Testimonial::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'photo' => 'user1.jpg'],
            ['content' => 'Kos bersih dan nyaman.', 'name' => 'rizky', 'rating' => 5]
        );


    }
}
