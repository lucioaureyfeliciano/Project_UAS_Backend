<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'tweet_id' => $tweet->id,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment->load('user')
        ], 201);
    }

    public function index($id)
    {
        $tweet = Tweet::findOrFail($id);
        $comments = Comment::where('tweet_id', $tweet->id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return response()->json($comments);
    }

    public function count($id)
    {
        $tweet = Tweet::findOrFail($id);
        $count = Comment::where('tweet_id', $tweet->id)->count();

        return response()->json(['count' => $count]);
    }

    public function show($id)
    {
        $comment = Comment::with(['user', 'tweet', 'parent', 'replies.user'])->findOrFail($id);

        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function storeReply(Request $request, $id)
    {
        $parentComment = Comment::findOrFail($id);
        
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $reply = Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'tweet_id' => $parentComment->tweet_id,
            'parent_id' => $parentComment->id,
        ]);

        return response()->json([
            'message' => 'Reply created successfully',
            'reply' => $reply->load('user')
        ], 201);
    }

    public function replies($id)
    {
        $comment = Comment::findOrFail($id);
        $replies = $comment->replies()->with('user')->latest()->get();

        return response()->json($replies);
    }
}
