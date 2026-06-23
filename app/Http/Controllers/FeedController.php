<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Hashtag;
use App\Models\Follow;
use App\Models\Block;
use App\Models\Mute;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $currentTab = $request->is('dashboard/following') ? 'following' : 'foryou';
        $authId = auth()->id();

        $excludedUserIds = Block::where('user_id', $authId)->pluck('blocked_user_id')->toArray();
        $mutedUserIds = Mute::where('user_id', $authId)->pluck('muted_user_id')->toArray();
        $ignoredIds = array_merge($excludedUserIds, $mutedUserIds);

        $privateUserIds = User::where('is_private', 1)->pluck('id')->toArray();

        $followedPrivateIds = Follow::where('follower_id', $authId)
            ->whereIn('following_id', $privateUserIds)
            ->pluck('following_id')
            ->toArray();

        $hiddenPrivateIds = array_diff($privateUserIds, $followedPrivateIds, [$authId]);

        $finalIgnoredIds = array_merge($ignoredIds, $hiddenPrivateIds);

        $tweetQuery = Tweet::with(['user', 'likes', 'dislikes', 'reposts', 'comments'])
            ->whereNotIn('user_id', $finalIgnoredIds);

        if ($currentTab === 'following') {
            $followingIds = Follow::where('follower_id', $authId)->pluck('following_id');
            $tweetQuery->whereIn('user_id', $followingIds->push($authId));
        }

        $tweets = $tweetQuery->latest()->get();
        $hashtags = Hashtag::withCount('tweets')->orderBy('tweets_count', 'desc')->take(5)->get();

        return view('dashboard', compact('tweets', 'hashtags', 'currentTab'));
    }
}