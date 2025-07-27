<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;

// Home
Route::get('/', [PageController::class, 'home'])->name('home');

//Blogs
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/blogs/live', [PageController::class, 'blogsLive']);

//About
Route::view('/about', 'pages.about')->name('about');

//Contact
Route::view('/contact', 'pages.contact')->name('contact');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Middleware for authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/blogpost/create', [BlogPostController::class, 'create'])->name('blogpost.create');
    Route::post('/blogpost', [BlogPostController::class, 'store'])->name('blogpost.store');
    Route::get('/blogpost/{slug}', [BlogPostController::class, 'show'])->name('blogpost.show');
    Route::get('/blogpost/{slug}/edit', [BlogPostController::class, 'edit'])->name('blogpost.edit');
    Route::put('/blogpost/{slug}', [BlogPostController::class, 'update'])->name('blogpost.update');
    Route::delete('/blogpost/{slug}', [BlogPostController::class, 'destroy'])->name('blogpost.destroy');
    Route::post('/blogpost/{slug}/comment', [CommentController::class, 'store'])->name('blogpost.comment.store');
    Route::get('/blogpost/{slug}/comments', [CommentController::class, 'fetchComments']);
    Route::post('/blogpost/{slug}/comments', [CommentController::class, 'storeComment']);

});
