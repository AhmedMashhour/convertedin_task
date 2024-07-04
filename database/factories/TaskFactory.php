<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'description' => fake()->text,
            'assigned_to_id' => User::factory()->create(),
            'assigned_by_id'=> User::query()->where('role',User::ROLE_TYPE_ADMIN)->inRandomOrder()->first()

        ];
    }
}
