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
use App\Http\Controllers\BlockController;
use App\Http\Controllers\MuteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FollowController;
use App\Models\Tweet;
use App\Http\Controllers\PrivacyController;

Route::get('/', function () {
    return redirect('/login');
});

# Dashboard Route
Route::get('/dashboard', [TweetController::class, 'show_tweets'])->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

# Tweet, Block, Mute, privacy Route
Route::middleware('auth')->group(function () {
    # Tweet Routes
    Route::post('/tweets', [TweetController::class, 'post_tweet']);
    Route::get('/tweets', [TweetController::class, 'show_tweets']);
    Route::get('/tweets/{id}', [TweetController::class, 'show'])->name('tweets.show');
    Route::delete('/tweets/{id}', [TweetController::class, 'delete_tweet']);
    Route::put('/tweets/{id}', [TweetController::class, 'edit_tweet']);
    
    # Block & Mute Routes (Menggunakan POST toggle untuk aksi masuk & keluar daftar)
    Route::post('/block/{blocked_user_id}', [BlockController::class, 'toggle'])->name('block');
    Route::post('/mute/{muted_user_id}', [MuteController::class, 'toggle'])->name('mute');

    # Privacy & List Detail Pages (Semua rute GET untuk memuat halaman)
    Route::get('/privacy', [PrivacyController::class, 'show_privacy'])->name('privacy');
    Route::post('/privacy/toggle', [PrivacyController::class, 'togglePrivacy'])->name('privacy.toggle');
    Route::get('/privacy/blocked', [PrivacyController::class, 'blocked_list'])->name('privacy.blocked');
    Route::get('/privacy/muted', [PrivacyController::class, 'muted_list'])->name('privacy.muted');
});

Route::middleware('auth')->group(function () {
    // comments
    Route::get('/tweets/{tweet_id}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/tweets/{tweet_id}/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/tweets/{tweet_id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/tweets/{tweet_id}/comments/{comment_id}/pin', [CommentController::class, 'pin'])->name('comments.pin');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comments.show');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{tweet_id}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/bookmarks/{id}', [BookmarkController::class, 'show'])->name('bookmarks.show');
});

Route::middleware('auth')->group(function () {
    # Usage Routes
    Route::get('/usage', [UsageController::class, 'index']);
    Route::get('/usage/users', [UsageController::class, 'users']);
    Route::get('/usage/tweets', [UsageController::class, 'tweets']);
    Route::get('/usage/communities', [UsageController::class, 'communities']);
    Route::get('/usage/follow-activities', [UsageController::class, 'followActivities']);
    Route::get('/usage/community-activities', [UsageController::class, 'communityActivities']);

    # Community Routes
    Route::get('/community', [CommunityController::class, 'index']);
    Route::post('/community', [CommunityController::class, 'create']);
    Route::get('/community/{id}', [CommunityController::class, 'show']);
    Route::put('/community/{id}', [CommunityController::class, 'edit']);
    Route::delete('/community/{id}', [CommunityController::class, 'destroy']);
    Route::post('/community/{id}/join', [CommunityController::class, 'join']);
    Route::post('/community/{id}/leave', [CommunityController::class, 'leave']);
    Route::post('/community/{id}/request-join', [CommunityController::class, 'requestToJoin']);
    Route::post('/community/{id}/requests/{requestId}/reject', [CommunityController::class, 'rejectRequest']);
    Route::post('/community/{id}/requests/{requestId}/approve', [CommunityController::class, 'approveRequest']);
});

# Dislike Routes
Route::post('/tweets/{tweet}/dislike', [DislikeController::class, 'toggle'])->middleware('auth');

# Like Routes
Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->middleware('auth');

# Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::get('/mentions/search', [ProfileController::class, 'searchMentions'])->middleware('auth');
Route::get('user/{username}', [ProfileController::class, 'show'])->middleware('auth')->name('profile.show');

# Update Description Profile
Route::post('/profile/update-description', [ProfileController::class, 'updateDescription']);

# Repost Routes
Route::post('/tweets/{tweet}/repost', [RepostController::class, 'toggle'])->middleware('auth');

# Follow Routes
Route::post(
    '/follow/{following_id}',
    [FollowController::class, 'toggle']
)->middleware('auth')->name('follow');

# followers list
Route::get(
    '/profile/{username}/followers',
    [ProfileController::class, 'followers']
)->middleware('auth')
    ->name('profile.followers');

# following list
Route::get(
    '/profile/{username}/following',
    [ProfileController::class, 'following']
)->middleware('auth')
    ->name('profile.following');

# Message Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages/inbox', [MessageController::class, 'inbox']);
    Route::post('/messages/share', [MessageController::class, 'shareToChat'])->name('messages.share');
    Route::get('/messages/chat/{userId}', [MessageController::class, 'chat']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::put('/messages/{messageId}', [MessageController::class, 'update']);
    Route::delete('/messages/{messageId}', [MessageController::class, 'destroy']);
    Route::get('/messages/search', [MessageController::class, 'search']);
});

// Hashtag Route
Route::get('/hashtags/{name}', [TweetController::class, 'showHashtag'])->middleware('auth');

// Search Route
Route::get(
    '/search/users',
    [ProfileController::class, 'search']
)->middleware('auth')
 ->name('search.users');
