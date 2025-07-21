<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagName = $this->faker->unique()->randomElement([
            'Beaches',
            'Hiking',
            'Street Food',
            'Festivals',
            'Wildlife',
            'Museums',
            'Road Trips',
            'Sunrise Spots',
            'Local Markets',
            'Luxury Resorts',
            'Backpacking',
            'Cultural Tours',
            'Street Art',
            'Historical Landmarks'
        ]);

        return [
            'tag_name' => $tagName,
            'slug' => Str::slug($tagName),
        ];
    }
}
