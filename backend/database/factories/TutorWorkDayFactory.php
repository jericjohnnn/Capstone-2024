<?php

namespace Database\Factories;

use App\Models\TutorWorkDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TutorWorkDay>
 */
class TutorWorkDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TutorWorkDay::class;

    public function definition(): array
    {
        // Random start time between 7 and 12
        $startTime = $this->faker->numberBetween(7, 12);
        // Random end time between start time + 4 and 19
        $endTime = $this->faker->numberBetween($startTime + 4, 19);

        return [
            'monday' => $this->faker->boolean(80) ? true : false,     // 80% chance of 'True'
            'tuesday' => $this->faker->boolean(80) ? true : false,    // 80% chance of 'True'
            'wednesday' => $this->faker->boolean(80) ? true : false,  // 80% chance of 'True'
            'thursday' => $this->faker->boolean(80) ? true : false,   // 80% chance of 'True'
            'friday' => $this->faker->boolean(80) ? true : false,     // 80% chance of 'True'
            'saturday' => $this->faker->boolean(40) ? true : false,   // 40% chance of 'True'
            'sunday' => $this->faker->boolean(20) ? true : false,    // 20% chance of 'True'
            'start_time' => $startTime,
            'end_time' => $endTime
        ];
    }
}
