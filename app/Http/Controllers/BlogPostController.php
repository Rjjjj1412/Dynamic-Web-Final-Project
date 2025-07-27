<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Comment;

class BlogPostController extends Controller
{
    // Show the Create Post Form
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();

        return view('blogpost.create', compact('tags', 'categories'));
    }

    // Store the New Post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:50480', // 50MB
            'status' => 'required|in:D,P',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);


        //Clean content: remove excessive empty paragraphs like <p>&nbsp;</p>
        $cleanedContent = preg_replace('/<p>(\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $request->input('content'));
        $cleanedContent = trim($cleanedContent);


        try {
            // Generate unique slug
            $slugBase = Str::slug($validated['title']);
            $slug = $slugBase;
            $counter = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $slugBase . '-' . $counter++;
            }

            // Handle featured image upload
            $imageUrl = null;
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $filename = time() . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $destination = public_path('uploads/posts');
                $image->move($destination, $filename);
                $imageUrl = 'uploads/posts/' . $filename; // relative path saved to DB
            }

            // Create the post
            $post = Post::create([
                'title' => $validated['title'],
                'content' => $cleanedContent,
                'slug' => $slug,
                'publication_date' => now(),
                'last_modified_date' => now(),
                'status' => $validated['status'],
                'featured_image_url' => $imageUrl,
                'views_count' => 0,
                'user_id' => Auth::id(),
            ]);

            // Sync categories and tags
            $post->categories()->sync($validated['categories']);
            $post->tags()->sync($validated['tags'] ?? []);

            return redirect()->route('blogpost.create')->with('success', 'Post created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Something went wrong. Please try again later.',
            ])->withInput();
        }
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('user')->firstOrFail();

        // Increment views
        $post->increment('views_count');

        // Optional: fetch related posts
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->whereHas('categories', function ($q) use ($post) {
                return $q->whereIn('id', $post->categories->pluck('id'));
            })
            ->take(3)
            ->get();

        // Fetch comments
        $comments = \App\Models\Comment::where('post_id', $post->id)
        ->where('is_hidden', false)
        ->orderByDesc('comment_date')
        ->get();

        return view('blogpost.show', compact('post', 'relatedPosts', 'comments'));
    }

    public function edit($slug)
    {
        // Fetch post by slug
        $post = Post::with(['categories', 'tags'])->where('slug', $slug)->firstOrFail();

        // Only owner can edit
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this post.');
        }

        // Only drafts can be edited
        if ($post->status !== 'D') {
            abort(403, 'Only draft posts can be edited.');
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('blogpost.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $slug)
    {
        // Fetch post using slug
        $post = Post::where('slug', $slug)->firstOrFail();

        // Ownership check
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to update this post.');
        }

        // Only drafts can be updated
        if ($post->status !== 'D') {
            abort(403, 'Only draft posts can be updated.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image',
            'status' => 'required|in:D,P',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $cleanedContent = preg_replace('/<p>(\s|&nbsp;|&#160;|<br\s*\/?>| )*<\/p>/i', '', $validated['content']);
        $cleanedContent = trim($cleanedContent);

        $post->title = $validated['title'];
        $post->content = $cleanedContent;
        $post->status = $validated['status'];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/posts', 'public');
            $post->featured_image_url = 'storage/' . $path;
        }

        $post->save();

        $post->categories()->sync($request->categories ?? []);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Allow only the post owner to delete
        if ($post->user_id !== Auth::id()){
            abort(403, 'You are not authorized to delete this post.');
        }

        // Detach related data
        $post->categories()->detach();
        $post->tags()->detach();

        // Delete the post
        $post->delete();

        return redirect('/blogs')->with('success', 'Post deleted successfully.');
    }
}
