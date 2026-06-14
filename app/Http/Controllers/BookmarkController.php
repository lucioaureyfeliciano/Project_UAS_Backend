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
        $bookmarks = Bookmark::where('user_id', auth()->id())
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
            ->latest()
            ->paginate(15);

        return view('bookmarks.index', compact('bookmarks'));
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