<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        // Check dependencies
        if ($users->isEmpty()) {
            throw new \Exception("No users found. Please run UserSeeder first.");
        }

        if ($categories->isEmpty()) {
            throw new \Exception("No categories found. Please run CategorySeeder first.");
        }

        if ($tags->isEmpty()) {
            throw new \Exception("No tags found. Please run TagSeeder first.");
        }

        // Load curated posts from JSON
        $jsonPath = database_path('data/posts.json');
        if (!file_exists($jsonPath)) {
            throw new \Exception("posts.json not found in database/data.");
        }

        $curatedPosts = collect(json_decode(file_get_contents($jsonPath), true));
        $expectedCount = 20;

        if ($curatedPosts->count() !== $expectedCount) {
            throw new \Exception("posts.json must contain exactly {$expectedCount} posts. Found: {$curatedPosts->count()}");
        }

        // Clear existing posts
        Post::truncate();

        $curatedPosts->each(function ($postData, $index) use ($users, $categories, $tags) {
            // Generate unique slug
            $slugBase = Str::slug($postData['title']);
            $slug = $slugBase;
            $counter = 1;

            while (Post::where('slug', $slug)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }

            $user = $users->random();

            // Handle image
            $imageFileName = "{$slugBase}.jpg";
            $imagePath = "posts/{$imageFileName}";

            if (!Storage::disk('public')->exists($imagePath)) {
                $imagePath = "posts/default.jpg";
                echo "No cached image for '{$postData['title']}', using default.\n";
            } else {
                echo "Using cached image: {$imageFileName}\n";
            }

            // Split content into sentences
            $sentences = preg_split('/(?<=[.!?])\s+(?=[A-Z])/', trim($postData['content']), -1, PREG_SPLIT_NO_EMPTY);

            // Group sentences into paragraphs of 3–5 sentences
            $paragraphs = collect($sentences)
                ->chunk(rand(3, 5))
                ->map(fn($chunk) => "<p>" . implode(' ', $chunk->all()) . "</p>")
                ->implode("\n");

            $finalContent = $paragraphs;

            // Create post
            $post = Post::create([
                'title'              => $postData['title'],
                'content'            => $finalContent,
                'slug'               => $slug,
                'user_id'            => $user->id,
                'publication_date'   => now()->subDays(rand(0, 365)),
                'status'             => fake()->randomElement(['D', 'P', 'I']),
                'featured_image_url' => Storage::url($imagePath),
                'views_count'        => fake()->numberBetween(50, 5000),
                'is_featured'        => $index < $categories->count(),
            ]);

            // Attach category
            $category = $categories[$index % $categories->count()];
            $post->categories()->attach([$category->id]);

            // Attach random tags
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        echo "\n Seeded {$curatedPosts->count()} curated posts successfully.\n";
    }
}
