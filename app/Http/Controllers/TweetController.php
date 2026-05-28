<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

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
        $tweets = Tweet::with('user', 'likes', 'dislikes')->latest()->get();
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
}
