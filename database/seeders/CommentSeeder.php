<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() === 0) {
            echo "No users or posts found, please run UserSeeder and PostSeeder first.\n";
            return;
        }
        Post::all()->each(function ($post) use ($users) {
            // Create 3 parent comments
            Comment::factory(3)->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ])->each(function ($parentComment) use ($users, $post) {
                // For each parent, create 1–2 replies
                Comment::factory(rand(1, 2))->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'parent_id' => $parentComment->id,
                ]);
            });
        });
    }
}
