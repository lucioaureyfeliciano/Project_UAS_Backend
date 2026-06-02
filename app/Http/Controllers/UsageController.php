<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Community;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Dislike;
use App\Models\Repost;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class UsageController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTweets = Tweet::count();
        $totalCommunities = Community::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();
        $totalDislikes = Dislike::count();
        $totalReposts = Repost::count();
        $totalMessages = Message::count();

        return view('usage.index', compact(
            'totalUsers',
            'totalTweets',
            'totalCommunities',
            'totalComments',
            'totalLikes',
            'totalDislikes',
            'totalReposts',
            'totalMessages'
        ));
    }
}