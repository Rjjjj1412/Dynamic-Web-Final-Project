<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home() {
    $featuredPosts = Post::latest()->take(5)->get()->map(function ($post) {
        return [
            'title' => $post->title,
            'excerpt' => Str::limit(strip_tags($post->content), 100),
            'content' => $post->content,
            'slug' => $post->slug,
            'image' => $post->featured_image_url,
        ];
    });

    return view('components.home', compact('featuredPosts'));
}

    public function contact() {
        return view('pages.contact');
    }
}
