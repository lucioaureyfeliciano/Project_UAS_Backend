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

        $tweet = Tweet::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Tweet posted successfully', 'tweet' => $tweet], 201);
        }

        return redirect('/dashboard')->with('success', 'Tweet posted successfully');
    }

    public function show_tweets()
    {
        $tweets = Tweet::with('user')->latest()->get();
        return response()->json($tweets);
    }

    public function delete_tweet($id)
    {
        $tweet = Tweet::findOrFail($id);

        if ($tweet->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tweet->delete();
        return response()->json(['message' => 'Tweet deleted successfully']);
    }

    public function edit_tweet(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);

        if ($tweet->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $tweet->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return response()->json(['message' => 'Tweet updated successfully', 'tweet' => $tweet]);
    }
}
