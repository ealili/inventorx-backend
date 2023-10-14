<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
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
            'title' => $this->faker->name(),
            'deadline' => $this->faker->dateTime(),
            'assignee_id' => rand(1, 10),
            'project_id' => rand(1, 10),
            'task_status_id' => rand(1, 4)
        ];
    }
}
