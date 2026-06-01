<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Models\Mute;

class TweetController extends Controller
{
    public function post_tweet(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Tweet::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        return redirect('/dashboard')->with('success', 'Tweet posted successfully.');
    }

    public function show_tweets()
    {
        $user_id = auth()->id();

        $blocked_user_id = Block::where('user_id', $user_id)
            ->pluck('blocked_user_id')
            ->toArray();

        $muted_user_id = Mute::where('user_id', $user_id)
            ->pluck('muted_user_id')
            ->toArray();

        $blacklist_user_ids = array_merge($blocked_user_id, $muted_user_id);

        $tweets = Tweet::with('user', 'likes', 'dislikes')
            ->whereNotIn('user_id', $blacklist_user_ids)
            ->latest()
            ->get();

        return view('dashboard', compact('tweets'));
    }

    public function delete_tweet($id)
    {
        $tweet = Tweet::findOrFail($id);

        if ($tweet->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        $tweet->delete();

        return back()->with('success', 'Tweet deleted successfully');
    }

    public function edit_tweet(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);

        if ($tweet->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $tweet->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Tweet updated successfully');
    }

    public function show_privacy()
    {
        $user_id = auth()->id();
        $blockedUsers = Block::where('user_id', $user_id)
            ->with('blockedUser')
            ->get();

        $mutedUsers = Mute::where('user_id', $user_id)
            ->with('mutedUser')
            ->get();

        return view('privacy', compact('blockedUsers', 'mutedUsers'));
    }
}