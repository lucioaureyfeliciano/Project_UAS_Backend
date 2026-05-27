<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;

class BookmarkWebController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('tweet.user')
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
}