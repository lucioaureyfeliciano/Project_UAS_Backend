<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Tweet;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Request $request, $id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'tweet_id' => 'required|exists:tweets,id',
        ]);

        $exists = Bookmark::where('user_id', $id)
            ->where('tweet_id', $validated['tweet_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Tweet already bookmarked'], 400);
        }

        $bookmark = Bookmark::create([
            'user_id' => $id,
            'tweet_id' => $validated['tweet_id'],
        ]);

        return response()->json([
            'message' => 'Bookmark created successfully',
            'bookmark' => $bookmark
        ], 201);
    }

    public function index($id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookmarks = Bookmark::where('user_id', $id)
            ->with('tweet.user')
            ->latest()
            ->get();

        return response()->json($bookmarks);
    }

    public function check($id, $tweet_id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $exists = Bookmark::where('user_id', $id)
            ->where('tweet_id', $tweet_id)
            ->exists();

        return response()->json(['bookmarked' => $exists]);
    }

    public function destroy($id, $tweet_id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookmark = Bookmark::where('user_id', $id)
            ->where('tweet_id', $tweet_id)
            ->firstOrFail();

        $bookmark->delete();

        return response()->json(['message' => 'Bookmark deleted successfully']);
    }

    public function destroyAll($id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $count = Bookmark::where('user_id', $id)->delete();

        return response()->json([
            'message' => 'All bookmarks deleted successfully',
            'deleted_count' => $count
        ]);
    }

    public function count($id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $count = Bookmark::where('user_id', $id)->count();

        return response()->json(['count' => $count]);
    }
}
