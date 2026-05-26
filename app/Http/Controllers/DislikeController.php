<?php

namespace App\Http\Controllers;

use App\Models\Dislike;
use App\Models\Tweet;

class DislikeController extends Controller
{
    public function toggle(Tweet $tweet)
    {
        $user = auth()->user();

        $dislike = $tweet->dislikes()->where('user_id', $user->id)->first();

        if ($dislike) {
            $dislike->delete();
        } else {
            $tweet->dislikes()->create([
                'user_id' => $user->id
            ]);
        }

        return response()->json([
            'count' => $tweet->dislikes()->count(),
            'status' => $dislike ? 'removed' : 'added'
        ]);
    }
}