<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Tutor;
use App\Models\TutorCertificate;
use App\Models\TutorSchool;
use App\Models\TutorWorkDay;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // this is an email verified seeder account. for unverified, you have to remove email_verified_at in factory
        Tutor::factory(20)->create()->each(function ($tutor) {
            // Create 2 certificates for each tutor
            TutorCertificate::factory(2)->create([
                'tutor_id' => $tutor->id
            ]);

            // Create 2 schools for each tutor
            TutorSchool::factory(2)->create([
                'tutor_id' => $tutor->id
            ]);

            // Create work days for each tutor
            TutorWorkDay::factory()->create([
                'tutor_id' => $tutor->id
            ]);

            // Assign between 1 to 3 random subjects to each tutor
            $subjectIds = Subject::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $tutor->subjects()->attach($subjectIds);
        });
    }
}
