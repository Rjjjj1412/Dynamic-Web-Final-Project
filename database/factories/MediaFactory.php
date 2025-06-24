<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_name' => $this->faker->unique()->word() . '.' . $this->faker->fileExtension(),
            'file_type' => $this->faker->randomElement(['image', 'video', 'audio']),
            'file_size' => $this->faker->numberBetween(1000, 5000000), // Size in bytes
            'url' => $this->faker->url(),
            'upload_date' => $this->faker->dateTimeThisYear(),
            'description' => $this->faker->sentence(),
        ];
    }
}
