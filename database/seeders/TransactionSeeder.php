<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{BoardingHouse, Room, Transaction};

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $bh1 = BoardingHouse::where('slug', 'kos-rzky-one')->first();

        $room1 = Room::where('boarding_house_id', $bh1->id)->where('name', 'Kamar A1')->first();

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
    }
}
