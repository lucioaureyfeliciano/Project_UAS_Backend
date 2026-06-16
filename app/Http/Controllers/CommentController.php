<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;

class CommentController extends Controller
{
    public function index($tweet_id)
    {
        $tweet = Tweet::with('user')->findOrFail($tweet_id);
        $sort = request('sort', 'newest');

        $query = Comment::where('tweet_id', $tweet_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user']);

        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'popular') {
            $query->withCount('replies')->orderByDesc('replies_count');
        } else {
            $query->latest();
        }

        $comments = $query->orderByDesc('is_pinned')->get();

        return view('comments.index', compact('tweet', 'comments', 'sort'));
    }

    public function create($tweet_id)
    {
        $tweet = Tweet::findOrFail($tweet_id);
        return view('comments.create', compact('tweet'));
    }

    public function store(Request $request, $tweet_id)
    {
        $validated = request()->validate(['content' => 'required|max:500']);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'tweet_id' => $tweet_id,
            'parent_id' => request()->input('parent_id', null),
        ]);

        $tweet = Tweet::find($tweet_id);
        if ($comment->parent_id) {
            $parentComment = Comment::find($comment->parent_id);
            if ($parentComment && $parentComment->user_id !== auth()->id()) {
                Notification::create([
                    'user_id' => $parentComment->user_id,
                    'type' => 'comment',
                    'message' => auth()->user()->username . ' replied to your comment',
                    'is_read' => false,
                    'related_user_id' => auth()->id(),
                    'tweet_id' => $tweet_id,
                ]);
            }

        } elseif ($tweet && $tweet->user_id !== auth()->id()) {
            Notification::create([
                'user_id' => $tweet->user_id,
                'type' => 'comment',
                'message' => auth()->user()->username . ' commented on your tweet "' . $tweet->title . '"',
                'is_read' => false,
                'related_user_id' => auth()->id(),
                'tweet_id' => $tweet_id,
            ]);
        }

        preg_match_all(
            '/@([a-zA-Z0-9_]+)/',
            $comment->content,
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

            if (
                $mentionedUser &&
                $mentionedUser->id != auth()->id()
            ) {
                Notification::create([
                    'user_id' => $mentionedUser->id,
                    'type' => 'mention',
                    'message' =>
                        auth()->user()->username .
                        ' mentioned you in a comment',
                    'is_read' => false,
                    'related_user_id' => auth()->id(),
                    'tweet_id' => $tweet_id,
                ]);
            }
        }
        return redirect()->route('tweets.show', $tweet_id)->with('success', 'Comment posted!');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== auth()->id())
            abort(403);
        return redirect()->route('comments.index', $comment->tweet_id);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== auth()->id())
            abort(403);

        $comment->update(request()->validate(['content' => 'required|max:500']));
        return redirect()->route('tweets.show', $comment->tweet_id)->with('success', 'Comment updated!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== auth()->id())
            abort(403);

        $tweet_id = $comment->tweet_id;
        $comment->delete();
        return redirect()->route('tweets.show', $tweet_id)->with('success', 'Deleted!');
    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.show', compact('comment'));
    }

    public function pin($tweet_id, $comment_id)
    {
        $tweet = Tweet::findOrFail($tweet_id);
        if ($tweet->user_id !== auth()->id())
            abort(403);

        $comment = Comment::findOrFail($comment_id);
        if ($comment->is_pinned) {
            $comment->update(['is_pinned' => false]);
            return back()->with('success', 'Pin removed.');
        }

        Comment::where('tweet_id', $tweet_id)->update(['is_pinned' => false]);

        $comment->update(['is_pinned' => true]);
        return back()->with('success', 'Comment pinned!');
    }
}
