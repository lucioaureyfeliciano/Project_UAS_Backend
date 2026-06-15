<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Models\Mute;
use App\Models\Hashtag;
use App\Models\User;
use App\Models\Notification;

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

        preg_match_all(
            '/#([a-zA-Z0-9_]+)/',
            $tweet->content,
            $matches
        );

        $mentionedUsers = array_unique(
            $matches[1]
        );

        foreach ($mentionedUsers as $username) {
            $mentionedUser = User::where(
                'username',
                $username
            )->first();

            if ($mentionedUser) {
                Notification::create([
                    'user_id' => $mentionedUser->id,
                    'type' => 'mention',
                    'message' =>
                        auth()->user()->username .
                        ' mentioned you in a tweet',
                    'is_read' => false,
                    'related_user_id' => auth()->id(),
                    'tweet_id' => $tweet->id,
                ]);
            }
        }

        foreach ($matches[1] as $tag) {

            $hashtag = Hashtag::firstOrCreate([
                'name' => strtolower($tag)
            ]);

            $tweet->hashtags()->syncWithoutDetaching([
                $hashtag->id
            ]);
        }

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

        $tweets = Tweet::with('user', 'likes', 'dislikes', 'reposts', 'comments')
            ->whereNotIn('user_id', $blacklist_user_ids)
            ->latest()
            ->get();

        $hashtags = Hashtag::withCount('tweets')
            ->orderByDesc('tweets_count')
            ->take(5)
            ->get();

        return view('dashboard', compact('tweets', 'hashtags'));
    }

    public function delete_tweet($id)
    {
        $tweet = Tweet::findOrFail($id);

        if ($tweet->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        $tweet->delete();
        Hashtag::doesntHave('tweets')->delete();

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

    public function show($id)
    {
        $tweet = Tweet::with([
            'user',
            'likes',
            'dislikes',
            'reposts',
            'bookmarks',
            'comments' => function ($q) {
                $q->whereNull('parent_id')
                    ->with(['user', 'replies.user'])
                    ->orderByDesc('is_pinned')
                    ->latest();
            }
        ])->findOrFail($id);

        return view('tweets.show', compact('tweet'));
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

    public function showHashtag($name)
    {
        $hashtag = Hashtag::where(
            'name',
            strtolower($name)
        )->firstOrFail();

        $tweets = $hashtag->tweets()
            ->with('user')
            ->latest()
            ->get();

        $hashtags = Hashtag::has('tweets')
            ->withCount('tweets')
            ->orderByDesc('tweets_count')
            ->get();

        return view(
            'hashtags.show',
            compact(
                'hashtag',
                'tweets',
                'hashtags'
            )
        );
    }
}