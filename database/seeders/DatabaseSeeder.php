<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Category;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Bonus;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\RoomImage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | CITIES (3)
        |--------------------------------------------------------------------------
        */
        $city1 = City::firstOrCreate(
            ['slug' => 'bandar-lampung'],
            ['name' => 'Bandar Lampung', 'image' => 'city1.jpg']
        );

        $city2 = City::firstOrCreate(
            ['slug' => 'metro'],
            ['name' => 'Metro', 'image' => 'city2.jpg']
        );

        $city3 = City::firstOrCreate(
            ['slug' => 'lampung-selatan'],
            ['name' => 'Lampung Selatan', 'image' => 'city3.jpg']
        );

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES (3)
        |--------------------------------------------------------------------------
        */
        $cat1 = Category::firstOrCreate(
            ['slug' => 'kos-putra'],
            ['name' => 'Kos Putra', 'image' => 'cat1.jpg']
        );

        $cat2 = Category::firstOrCreate(
            ['slug' => 'kos-putri'],
            ['name' => 'Kos Putri', 'image' => 'cat2.jpg']
        );

        $cat3 = Category::firstOrCreate(
            ['slug' => 'kos-campur'],
            ['name' => 'Kos Campur', 'image' => 'cat3.jpg']
        );

        /*
        |--------------------------------------------------------------------------
        | BOARDING HOUSES (3)
        |--------------------------------------------------------------------------
        */
        $bh1 = BoardingHouse::firstOrCreate(
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

        $bh2 = BoardingHouse::firstOrCreate(
            ['slug' => 'kos-rzky-two'],
            [
                'name' => 'Kos Rzky Two',
                'thumbnail' => 'kos2.jpg',
                'city_id' => $city2->id,
                'category_id' => $cat2->id,
                'description' => 'Kos eksklusif khusus putri.',
                'price' => 900000,
                'address' => 'Jl. AH Nasution',
            ]
        );

        $bh3 = BoardingHouse::firstOrCreate(
            ['slug' => 'kos-rzky-three'],
            [
                'name' => 'Kos Rzky Three',
                'thumbnail' => 'kos3.jpg',
                'city_id' => $city3->id,
                'category_id' => $cat3->id,
                'description' => 'Kos campur fasilitas lengkap.',
                'price' => 750000,
                'address' => 'Jl. Soekarno Hatta',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ROOMS (3)
        |--------------------------------------------------------------------------
        | Kunci unik aman: boarding_house_id + name
        */
        $room1 = Room::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'name' => 'Kamar A1'],
            [
                'room_type' => 'Standard',
                'square_feet' => 12,
                'capacity' => 1,
                'price_per_month' => 800000,
                'is_available' => 1,
            ]
        );

        $room2 = Room::firstOrCreate(
            ['boarding_house_id' => $bh2->id, 'name' => 'Kamar B1'],
            [
                'room_type' => 'Premium',
                'square_feet' => 16,
                'capacity' => 1,
                'price_per_month' => 900000,
                'is_available' => 1,
            ]
        );

        $room3 = Room::firstOrCreate(
            ['boarding_house_id' => $bh3->id, 'name' => 'Kamar C1'],
            [
                'room_type' => 'Standard',
                'square_feet' => 14,
                'capacity' => 2,
                'price_per_month' => 750000,
                'is_available' => 1,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | BONUSES (3)
        |--------------------------------------------------------------------------
        | Kunci unik aman: boarding_house_id + name
        */
        Bonus::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'name' => 'Free WiFi'],
            ['description' => 'Internet 24 jam', 'image' => 'wifi.jpg']
        );

        Bonus::firstOrCreate(
            ['boarding_house_id' => $bh2->id, 'name' => 'Free Laundry'],
            ['description' => 'Laundry mingguan', 'image' => 'laundry.jpg']
        );

        Bonus::firstOrCreate(
            ['boarding_house_id' => $bh3->id, 'name' => 'Parkir Luas'],
            ['description' => 'Aman dan tertutup', 'image' => 'parkir.jpg']
        );

        /*
        |--------------------------------------------------------------------------
        | TESTIMONIALS (3)
        |--------------------------------------------------------------------------
        | Kunci unik aman: boarding_house_id + photo (atau + content)
        */
        Testimonial::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'photo' => 'user1.jpg'],
            ['content' => 'Kos bersih dan nyaman.', 'name' => 'rizky',  'rating' => 5]
        );

        Testimonial::firstOrCreate(
            ['boarding_house_id' => $bh2->id, 'photo' => 'user2.jpg'],
            ['content' => 'Lingkungan aman.', 'name' => 'rizky', 'rating' => 4]
        );

        Testimonial::firstOrCreate(
            ['boarding_house_id' => $bh3->id, 'photo' => 'user3.jpg'],
            ['content' => 'Harga terjangkau.', 'name' => 'rizky', 'rating' => 4]
        );

        /*
        |--------------------------------------------------------------------------
        | TRANSACTIONS (3)
        |--------------------------------------------------------------------------
        | Kunci unik paling aman: code
        */
        Transaction::firstOrCreate(
            ['code' => 'TRX-001'],
            [
                'boarding_house_id' => $bh1->id,
                'room_id' => $room1->id,
                'name' => 'Andi',
                'email' => 'andi@gmail.com',
                'phone_number' => '081234567890',
                'payment_method' => 'full_payment',
                'payment_status' => 'paid',
                'start_date' => now(),
                'duration' => 6,
                'total_amount' => 4800000,
                'transaction_date' => now(),
                'snap_token' => null,
            ]
        );

        Transaction::firstOrCreate(
            ['code' => 'TRX-002'],
            [
                'boarding_house_id' => $bh2->id,
                'room_id' => $room2->id,
                'name' => 'Budi',
                'email' => 'budi@gmail.com',
                'phone_number' => '082345678901',
                'payment_method' => 'down_payment',
                'payment_status' => 'pending',
                'start_date' => now(),
                'duration' => 3,
                'total_amount' => 2700000,
                'transaction_date' => now(),
                'snap_token' => null,
            ]
        );

        Transaction::firstOrCreate(
            ['code' => 'TRX-003'],
            [
                'boarding_house_id' => $bh3->id,
                'room_id' => $room3->id,
                'name' => 'Citra',
                'email' => 'citra@gmail.com',
                'phone_number' => '083456789012',
                'payment_method' => 'full_payment',
                'payment_status' => 'paid',
                'start_date' => now(),
                'duration' => 12,
                'total_amount' => 9000000,
                'transaction_date' => now(),
                'snap_token' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ROOM IMAGES (3)
        |--------------------------------------------------------------------------
        | Kunci unik aman: room_id + image
        */
        RoomImage::firstOrCreate(
            ['room_id' => $room1->id, 'image' => 'room1_1.jpg']
        );

        RoomImage::firstOrCreate(
            ['room_id' => $room2->id, 'image' => 'room2_1.jpg']
        );

        RoomImage::firstOrCreate(
            ['room_id' => $room3->id, 'image' => 'room3_1.jpg']
        );
    }
}
