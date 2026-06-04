<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;
use App\Models\Notification;

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

            // notif from like
            if ($tweet->user_id !== $user->id) {
                Notification::create([
                    'user_id'         => $tweet->user_id,
                    'type'            => 'like',
                    'message'         => $user->username . ' liked your tweet "' . $tweet->title . '"',
                    'is_read'         => false,
                    'related_user_id' => $user->id,
                    'tweet_id'        => $tweet->id,
                ]);
            }
        }

        return request()->expectsJson()
            ? response()->json(['count' => $tweet->likes()->count(), 'status' => $like ? 'removed' : 'added'])
            : redirect()->back();
        }
}