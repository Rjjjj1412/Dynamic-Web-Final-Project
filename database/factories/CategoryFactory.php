<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $catName = $this->faker->randomElement([
        'News', 'Review', 'Podcast', 'Opinion', 'Lifestyle', 'Tech', 'Education', 'Entertainment'
          ]);
        return [
            'category_name' => $catName,
            'slug' => Str::slug($catName),
            'description' => fake()->sentence(rand(1, 5))
        ];
    }
}
