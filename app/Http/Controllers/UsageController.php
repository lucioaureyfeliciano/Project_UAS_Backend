<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Community;
use Illuminate\Support\Facades\DB;

class UsageController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTweets = Tweet::count();
        $totalCommunities = Community::count();
        $totalMemberships = DB::table('community_user')->count();
        $lastUpdated = now();

        return view('usage.index', compact(
            'totalUsers',
            'totalTweets',
            'totalCommunities',
            'totalMemberships',
            'lastUpdated'
        ));
    }
}