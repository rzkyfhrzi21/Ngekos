<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['slug' => 'kos-putra'],
            ['name' => 'Kos Putra', 'image' => 'cat1.jpg']
        );
    }
}
