<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with(
            'followers',
            'following'
        )->find(auth()->id());

        $tweets = Tweet::with('likes', 'reposts')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile', compact('user', 'tweets'))->with('isLocked', false);
    }

    public function updateDescription(Request $request)
    {
        $user = auth()->user();

        $user->description = $request->description;

        $user->save();

        return back()->with('success', 'Description updated successfully');
    }

    public function show($username)
    {
        $user = User::with(
            'followers',
            'following'
        )
            ->where(
                'username',
                $username
            )
            ->firstOrFail();

        if ($user->is_private == 1 && auth()->id() != $user->id) {
            $tweets = collect();
            $isLocked = true;

            return view('profile', compact('user', 'tweets', 'isLocked'));
        }

        $tweets = Tweet::where('user_id', $user->id)
            ->with(['likes', 'dislikes', 'reposts'])
            ->latest()
            ->get();

        $isLocked = false;

        return view('profile', compact('user', 'tweets', 'isLocked'));
    }

}