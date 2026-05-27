<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\CommunityController;

Route::get('/', function () {
    return redirect('/login');
});

use App\Models\Tweet;

Route::get('/dashboard', function () {
    $tweets = Tweet::with('user')->latest()->get();
    return view('dashboard', compact('tweets'));
})->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/tweets', [TweetController::class, 'post_tweet']);
    Route::get('/tweets', [TweetController::class, 'show_tweets']);
    Route::delete('/tweets/{id}', [TweetController::class, 'delete_tweet']);
    Route::put('/tweets/{id}', [TweetController::class, 'edit_tweet']);
});

Route::middleware('auth')->group(function () {
    Route::get('/community', [CommunityController::class, 'index']);
    Route::post('/community', [CommunityController::class, 'create']);
    Route::get('/community/{id}', [CommunityController::class, 'show']);
    Route::put('/community/{id}', [CommunityController::class, 'edit']);
    Route::delete('/community/{id}', [CommunityController::class, 'destroy']);
    Route::post('/community/{id}/join', [CommunityController::class, 'join']);
    Route::post('/community/{id}/leave', [CommunityController::class, 'leave']);
});
