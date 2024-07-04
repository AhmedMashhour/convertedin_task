<?php

namespace Database\Seeders;

use App\Models\Statistics;
use App\Models\Task;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(99)->create([
            'role' => User::ROLE_TYPE_ADMIN
        ]);
        User::factory()->create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'role' => User::ROLE_TYPE_ADMIN
        ]);
        Task::factory(10000)->create();


        User::query()->withCount('user_tasks')
            ->where('role', User::ROLE_TYPE_USER)
            ->each(function ($user) {
                Statistics::query()->create([
                    'user_id' => $user->id,
                    'total_tasks' => $user->user_tasks_count,
                ]);

            });


    }
}
