<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $posts = Post::all();

        if ($posts->isEmpty()) {
            echo "No posts found. Please seed posts first.";
            return;
        }

        Media::factory()->count(20)->make()->each(function ($media) use ($posts) {
            $media->post_id = $posts->random()->id;
            $media->save();
        });
    }
}
