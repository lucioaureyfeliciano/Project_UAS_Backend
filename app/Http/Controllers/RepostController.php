<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Repost;

class RepostController extends Controller
{
    public function toggle(Tweet $tweet)
    {
        $user = auth()->user();

        $repost = $tweet->reposts()
            ->where('user_id', $user->id)
            ->first();

        if ($repost) {

            $repost->delete();

            $status = 'removed';

        } else {

            $tweet->reposts()->create([
                'user_id' => $user->id
            ]);

            $status = 'added';
        }

        return response()->json([
            'count' => $tweet->reposts()->count(),
            'status' => $status
        ]);
    }
}