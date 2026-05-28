<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return redirect('/login');
});

use App\Models\Tweet;

Route::get('/dashboard', function () {
    $tweets = Tweet::with('user', 'likes', 'dislikes')->latest()->get();
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
    // comments
    Route::get('/tweets/{tweet_id}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/tweets/{tweet_id}/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/tweets/{tweet_id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comments.show');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');

    // bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{tweet_id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/bookmarks/{id}', [BookmarkController::class, 'show'])->name('bookmarks.show');
});

# Usage Routes
Route::middleware('auth')->group(function () {
    Route::get('/usage', [UsageController::class, 'index']);
});

# Community Routes
Route::middleware('auth')->group(function () {
    Route::get('/community', [CommunityController::class, 'index']);
    Route::post('/community', [CommunityController::class, 'create']);
    Route::get('/community/{id}', [CommunityController::class, 'show']);
    Route::put('/community/{id}', [CommunityController::class, 'edit']);
    Route::delete('/community/{id}', [CommunityController::class, 'destroy']);
    Route::post('/community/{id}/join', [CommunityController::class, 'join']);
    Route::post('/community/{id}/leave', [CommunityController::class, 'leave']);
});

# Dislike Routes
Route::post('/tweets/{tweet}/dislike', [DislikeController::class, 'toggle'])->middleware('auth');

# Like Routes
Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->middleware('auth');

# Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');

# Update Description Profile
Route::post('/profile/update-description', [ProfileController::class, 'updateDescription']);

# Repost Routes
Route::post('/tweets/{tweet}/repost', [RepostController::class, 'toggle'])->middleware('auth');

#Message Routes
Route::middleware('auth')->group(function () {

    Route::get('/messages/inbox', [MessageController::class, 'inbox']);

    Route::get('/messages/chat/{userId}', [MessageController::class, 'chat']);

    Route::post('/messages', [MessageController::class, 'store']);

    Route::put('/messages/{messageId}', [MessageController::class, 'update']);

    Route::delete('/messages/{messageId}', [MessageController::class, 'destroy']);

    Route::get('/messages/search', [MessageController::class, 'search']);
});

