<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sort   = $request->sort ?? 'newest';
        $bookmarks = Bookmark::where('bookmarks.user_id', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->whereHas('tweet', function ($tweet) use ($search) {
                    $tweet->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {
                            $user->where('username', 'like', "%{$search}%");
                        });
                });
            })
            ->with(['tweet.user', 'tweet.likes', 'tweet.dislikes', 'tweet.reposts', 'tweet.comments'])
            ->when($sort === 'oldest', function ($query) {$query->oldest();})
            ->when($sort === 'newest', function ($query) {$query->latest();})
            ->when($sort === 'author', function ($query) {
                $query->join('tweets', 'bookmarks.tweet_id', '=', 'tweets.id')
                    ->join('users', 'tweets.user_id', '=', 'users.id')
                    ->orderBy('users.username')
                    ->select('bookmarks.*');
            })
            ->paginate(15)
            ->withQueryString();

        return view('bookmarks.index', compact('bookmarks', 'sort'));
    }

    public function store()
    {
        $validated = request()->validate(['tweet_id' => 'required|exists:tweets,id']);

        if (Bookmark::where('user_id', auth()->id())->where('tweet_id', $validated['tweet_id'])->exists()) {
            return back()->with('error', 'Already bookmarked');
        }

        Bookmark::create([
            'user_id' => auth()->id(),
            'tweet_id' => $validated['tweet_id'],
        ]);

        return back()->with('success', 'Bookmarked!');
    }

    public function destroy($tweet_id)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())
            ->where('tweet_id', $tweet_id)->firstOrFail();
        $bookmark->delete();
        return back()->with('success', 'Removed!');
    }

    public function show($id)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())->findOrFail($id);
        return view('bookmarks.show', compact('bookmark'));
    }

}