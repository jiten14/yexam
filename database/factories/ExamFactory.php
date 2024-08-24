<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>rand(1, 20),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(1),
            'time_limit' => rand(1200,7200),

        ];
    }
}
