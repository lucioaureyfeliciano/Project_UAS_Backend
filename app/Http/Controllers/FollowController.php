<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    protected NotificationService $notifications;

    public function __construct(NotificationService $notifications)
    {
        $this->notifications = $notifications;
    }

    public function toggle($following_id)
    {
        $user = auth()->user();

        if ($user->id == $following_id) {
            return back()->with('error', 'You cannot follow yourself');
        }

        return DB::transaction(function () use ($user, $following_id) {
            $existingFollow = Follow::where('follower_id', $user->id)
                ->where('following_id', $following_id)
                ->first();

            if ($existingFollow) {
                $existingFollow->delete();
                return back()->with('success', 'User unfollowed successfully');
            }

            Follow::create([
                'follower_id' => $user->id,
                'following_id' => $following_id
            ]);

            $this->notifications->create(
                $following_id,
                'follow',
                $user->username . ' started following you',
                $user->id,
                null
            );

            return back()->with('success', 'User followed successfully');
        });
    }
}