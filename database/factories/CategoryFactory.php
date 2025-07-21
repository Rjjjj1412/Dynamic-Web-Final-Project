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
        $catName = $this->faker->unique()->randomElement([
            'Travel',
            'Food & Drink',
            'Culture',
            'Adventure',
            'Photography',
            'Hidden Gems',
            'Seasonal'
        ]);

        return [
            'category_name' => $catName,
            'slug' => Str::slug($catName),
            'description' => $this->faker->sentence(rand(8, 15)), // Longer travel-related desc
        ];
    }
}
