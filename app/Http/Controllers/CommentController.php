<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    // Fetch Comments
    public function fetchComments($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $comments = $post->comments()
        ->where('is_hidden', false)
        ->orderBy('comment_date', 'desc')
        ->paginate(5);

        return response()->json($comments);
    }

    // Store Comment
    public function storeComment(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'required|email',
            'comment_content' => 'required|string',
        ]);

        $comment = new Comment([
            'reviewer_name' => $validated['reviewer_name'],
            'reviewer_email' => $validated['reviewer_email'],
            'comment_content' => $validated['comment_content'],
            'comment_date' => now(),
            'is_hidden' => false,
            'user_id' => Auth::check() ? Auth::id() : null,
        ]);

        $post->comments()->save($comment);

        return response()->json(['message' => 'Comment posted!']);
    }
}