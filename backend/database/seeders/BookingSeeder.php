<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDate;
use App\Models\BookingMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::factory()
        ->count(10)
        ->has(
            BookingMessage::factory()
                ->count(1)
                ->has(BookingDate::factory()->count(2), 'dates'),  // Each message has 2 dates
            'messages'
        )
        ->create();
    }
}
