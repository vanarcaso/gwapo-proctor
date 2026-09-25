<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Task> */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_name' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => 'Pending',
            'due_date' => '2026-10-01',
        ];
    }
}
