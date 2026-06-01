<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle($following_id)
    {
        $user = auth()->user();

        if ($user->id == $following_id) {
            return back()->with(
                'error',
                'You cannot follow yourself'
            );
        }

        $existingFollow = Follow::where(
            'follower_id',
            $user->id
        )->where(
                'following_id',
                $following_id
            )->first();

        if ($existingFollow) {

            $existingFollow->delete();

            return back()->with(
                'success',
                'User unfollowed successfully'
            );
        }

        Follow::create([
            'follower_id' => $user->id,
            'following_id' => $following_id
        ]);

        Notification::create([
            'user_id' => $following_id,
            'type' => 'follow',
            'message' => $user->username . ' started following you',
            'related_user_id' => $user->id,
            'is_read' => false
        ]);

        return back()->with(
            'success',
            'User followed successfully'
        );
    }
}