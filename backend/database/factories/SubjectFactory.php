<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Subject::class;

    public function definition(): array
    {
        $subjects = [
            'Mathematics',
            'Science',
            'History',
            'Literature',
            'Biology',
            'Chemistry',
            'Physics',
            'Geography',
            'Computer Science',
            'Art',
            'Music',
            'Physical Education',
            'Economics',
            'Philosophy',
            'Psychology',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($subjects),
        ];
    }
}
