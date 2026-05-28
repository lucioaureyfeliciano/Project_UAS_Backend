<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;

class LikeController extends Controller
{
    public function toggle(Tweet $tweet)
    {
        $user = auth()->user();

        $like = $tweet->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $tweet->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return response()->json([
            'count' => $tweet->likes()->count(),
            'status' => $like ? 'removed' : 'added'
        ]);
    }
}