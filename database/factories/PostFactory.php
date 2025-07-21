<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6, true);
        $baseSlug = Str::slug($title);
        $uniqueSlug = $this->generateUniqueSlug($baseSlug);

        // Random fallback images stored in posts/
        $fallbackImages = [
            'posts/default1.jpg',
            'posts/default2.jpg',
            'posts/default3.jpg',
        ];
        $imagePath = $this->faker->randomElement($fallbackImages);

        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true),
            'slug' => $uniqueSlug,
            'publication_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['D', 'P', 'I']),
            'featured_image_url' => Storage::url($imagePath), // Serve from storage
            'views_count' => $this->faker->numberBetween(50, 5000),
            'is_featured' => $this->faker->boolean(20),
        ];
    }

    /**
     * Generate a unique slug for the Post model
     */
    protected function generateUniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}
