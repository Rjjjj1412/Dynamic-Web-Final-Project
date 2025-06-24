<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding Post then attach user id on it
        $users = User::all();

        if ($users->count() === 0) {
            echo "No users found, please run UserSeeder first.\n";
            return;
        }

        Post::factory(10)->create([
            'user_id' => $users->random()->id,
        ]);

        //////////

        // Attach categories of Post
        $categories = Category::all();
        $posts = Post::all();

        if ($categories->isEmpty()) {
        echo "No categories found. Please run CategorySeeder.\n";
        return;
    }
        foreach ($posts as $post) {
            $randomCats = $categories->random(rand(1, 3));
            $post->categories()->attach($randomCats);
        }

        // Attach tags of Post
        $tags = Tag::all();

        if ($tags->isEmpty()) {
        echo " No tags found. Please run TagSeeder.\n";
        return;
    }
        foreach ($posts as $post) {
            $randomTags = $tags->random(rand(1, 3));
            $post->tags()->attach($randomTags);
        }
    }
}
