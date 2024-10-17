<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define user types to insert
        $types = [
            ['type' => 'Tutor'],
            ['type' => 'Student'],
            ['type' => 'Admin'],
        ];

        // Insert user types into the table
        UserType::insert($types);
    }
}
