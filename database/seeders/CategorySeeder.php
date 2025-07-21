<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Travel',
                'description' => 'Explore the world’s most amazing destinations.',
            ],
            [
                'category_name' => 'Food & Drink',
                'description' => 'Culinary journeys from street food to fine dining.',
            ],
            [
                'category_name' => 'Culture',
                'description' => 'Dive into local traditions and global cultures.',
            ],
            [
                'category_name' => 'Adventure',
                'description' => 'Hiking, biking, and adrenaline-packed travels.',
            ],
            [
                'category_name' => 'Photography',
                'description' => 'Capture the beauty of the world through a lens.',
            ],
            [
                'category_name' => 'Hidden Gems',
                'description' => 'Discover off-the-beaten-path locations.',
            ],
            [
                'category_name' => 'Seasonal',
                'description' => 'Best spots to visit each season.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['category_name'])], // Avoid duplicates
                [
                    'category_name' => $category['category_name'],
                    'slug' => Str::slug($category['category_name']),
                    'description' => $category['description'],
                ]
            );
        }
    }
}
