<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Random existing user
            'message' => $this->faker->sentence(), // Example message content
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
