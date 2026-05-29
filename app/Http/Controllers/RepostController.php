<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Repost;
use App\Models\Notification;

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

            // notif from repost
            if ($tweet->user_id !== $user->id) {
                Notification::create([
                    'user_id'         => $tweet->user_id,
                    'type'            => 'repost',
                    'message'         => $user->username . ' reposted your tweet "' . $tweet->title . '"',
                    'is_read'         => false,
                    'related_user_id' => $user->id,
                    'tweet_id'        => $tweet->id,
                ]);
            }

            $status = 'added';
        }

        return response()->json([
            'count' => $tweet->reposts()->count(),
            'status' => $status
        ]);
    }
}