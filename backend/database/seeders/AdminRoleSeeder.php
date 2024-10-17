<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminRole;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the roles to insert
        $roles = [
            ['role' => 'Admin'],
            ['role' => 'Viewer'],
        ];

        // Insert roles into the admin_roles table
        AdminRole::insert($roles);
    }
}
