<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return redirect('/login');
});

use App\Models\Tweet;

# Dashboard Route
Route::get('/dashboard', function () {
    $tweets = Tweet::with('user', 'likes', 'dislikes')->latest()->get();
    return view('dashboard', compact('tweets'));
})->middleware('auth');

# Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

# Tweet Routes
Route::middleware('auth')->group(function () {
    Route::post('/tweets', [TweetController::class, 'post_tweet']);
    Route::get('/tweets', [TweetController::class, 'show_tweets']);
    Route::delete('/tweets/{id}', [TweetController::class, 'delete_tweet']);
    Route::put('/tweets/{id}', [TweetController::class, 'edit_tweet']);
});

# Dislike Routes
Route::post('/tweets/{tweet}/dislike', [DislikeController::class, 'toggle'])->middleware('auth');

# Like ROutes
Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->middleware('auth');