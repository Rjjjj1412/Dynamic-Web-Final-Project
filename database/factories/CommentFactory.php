<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment_content' => fake()->paragraph(),
            'comment_date' => now(),
            'reviewer_name' => fake()->name(),
            'reviewer_email' => fake()->unique()->safeEmail(),
            'is_hidden' => false,
        ];
    }
}
