<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\Web\CommentWebController;
use App\Http\Controllers\Web\NotificationWebController;
use App\Http\Controllers\Web\BookmarkWebController;

Route::get('/', function () {
    return redirect('/login');
});

use App\Models\Tweet;

# Dashboard Route
Route::get('/dashboard', function () {
    $tweets = Tweet::with('user')->latest()->get();
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

Route::middleware('auth')->group(function () {
    // comments
    Route::get('/tweets/{tweet_id}/comments', [CommentWebController::class, 'index'])->name('comments.index');
    Route::get('/tweets/{tweet_id}/comments/create', [CommentWebController::class, 'create'])->name('comments.create');
    Route::post('/tweets/{tweet_id}/comments', [CommentWebController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentWebController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentWebController::class, 'update'])->name('comments.update');
    Route::get('/comments/{id}', [CommentWebController::class, 'show'])->name('comments.show');
    Route::delete('/comments/{id}', [CommentWebController::class, 'destroy'])->name('comments.destroy');

    // notifications
    Route::get('/notifications', [NotificationWebController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/{id}/read', [NotificationWebController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationWebController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/{id}', [NotificationWebController::class, 'show'])->name('notifications.show');

    // bookmarks
    Route::get('/bookmarks', [BookmarkWebController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkWebController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{tweet_id}', [BookmarkWebController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/bookmarks/{id}', [BookmarkWebController::class, 'show'])->name('bookmarks.show');
});