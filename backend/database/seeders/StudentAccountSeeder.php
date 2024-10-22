<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // this is an email verified seeder account. for unverified, you have to remove email_verified_at
        $user = User::create([
            'user_type' => 2,
            'email' => 'student@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);
        Student::create([
            'user_id' => $user->id,
            'first_name' => "student",
            'last_name' => "account",
            'address' => "student,toledo,cebu",
            'birthdate' => "2024-10-22",
            'contact_number' => "09123456789",
        ]);
    }
}
