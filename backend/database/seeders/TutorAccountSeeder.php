<?php

namespace Database\Seeders;

use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // this is an email verified seeder account. for unverified, you have to remove email_verified_at
        $user = User::create([
            'user_type' => 1,
            'email' => 'tutor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);
        Tutor::create([
            'user_id' => $user->id,
            'first_name' => "tutor",
            'last_name' => "account",
            'address' => "tutor,toledo,cebu",
            'birthdate' => "2024-10-22",
            'gender' => "male",
            'contact_number' => "09123456789",
        ]);
    }
}
