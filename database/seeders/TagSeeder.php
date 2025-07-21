<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
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
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => Str::slug($tag)], // Prevent duplicates
                [
                    'tag_name' => $tag,
                    'slug' => Str::slug($tag),
                ]
            );
        }
    }
}
