<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $selectedCategory = $request->query('category');

        // Base query: all published posts
        $query = Post::orderByDesc('publication_date');

        // If category is selected, filter the posts
        if ($selectedCategory) {
            $query->whereHas('categories', function ($q) use ($selectedCategory) {
                $q->where('category_name', $selectedCategory);
            });
        }

        // Paginate results, retain query string for pagination links
        $recentPosts = $query->paginate(5)->withQueryString();

        // Handle AJAX request for partial updates
        if ($request->ajax()) {
            return view('components.recent-posts-pagination', compact('recentPosts'))->render();
        }

        // Featured posts (limit to 5 and mapped)
        $featuredPosts = Post::where('is_featured', true)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'excerpt' => Str::limit(strip_tags($post->content), 500),
                    'slug' => $post->slug,
                    'image' => $post->featured_image_url,
                    'author' => optional($post->user)->name ?? 'Unknown',
                    'publication_date' => $post->publication_date
                        ? Carbon::parse($post->publication_date)->format('F j, Y')
                        : null,
                ];
            });

        // Popular posts (top 5 by views)
        $popularPosts = Post::orderByDesc('views_count')->take(5)->get();

        // All categories for sidebar buttons
        $categories = Category::all();

        return view('pages.home', compact(
            'featuredPosts',
            'recentPosts',
            'popularPosts',
            'categories',
            'selectedCategory'
        ));
    }

    public function blogs(Request $request)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('pages.blogs', compact('categories', 'tags'));
    }

    public function blogsLive(Request $request)
    {
        $query = Post::with(['user', 'categories', 'tags']);

        // Keyword Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_name', $request->category);
            });
        }

        // Filter by Tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tag_name', $request->tag);
            });
        }

        // Sort by date
        if ($request->sort === 'oldest') {
            $query->orderBy('publication_date', 'asc');
        } else {
            $query->orderBy('publication_date', 'desc');
        }

        $posts = $query->paginate(10);

        return view('components.blogs-list', compact('posts'))->render();
    }
}
