<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Follow;
use App\Models\Community;
use App\Models\CommunityActivity;
use App\Models\CommunityJoinRequest;

class UsageController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTweets = Tweet::count();
        $followActivities = Follow::count();
        $totalCommunities = Community::count();
        $communityActivities = CommunityActivity::count();

        return view('usage.index', compact(
            'totalUsers',
            'totalTweets',
            'followActivities',
            'totalCommunities',
            'communityActivities',
        ));
    }

    public function users()
    {
        $users = User::latest()->get();

        return view('usage.detail', [
            'title' => 'All Users',
            'items' => $users,
        ]);
    }

    public function tweets()
    {
        $tweets = Tweet::with('user')->latest()->get();

        return view('usage.detail', [
            'title' => 'All Tweets',
            'items' => $tweets,
        ]);
    }

    public function communities()
    {
        $communities = Community::with('creator')->latest()->get();

        return view('usage.detail', [
            'title' => 'All Communities',
            'items' => $communities,
        ]);
    }

    public function communityActivities()
    {
        $activities = CommunityActivity::with('user', 'community')
            ->latest()
            ->get();

        return view('usage.detail', [
            'title' => 'Community Activities',
            'items' => $activities,
        ]);
    }

    public function followActivities()
    {
        $activities = Follow::with([
            'follower',
            'following'
        ])
        ->latest()
        ->get();

        return view('usage.detail', [
            'title' => 'Follow Activities',
            'items' => $activities,
        ]);
    }
}
