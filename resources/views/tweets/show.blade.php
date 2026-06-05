<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $tweet->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            color: #222;
        }

        .navbar {
            background: #3490dc;
            padding: 14px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
 
        .navbar .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
 
        .navbar .back-btn:hover { opacity: 0.8; }
 
        .navbar .title {
            font-size: 15px;
            font-weight: bold;
        }
 
        .container {
            width: 650px;
            margin: 28px auto;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #a3cfbb;
            font-size: 14px;
        }

        .tweet-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 22px;
            margin-bottom: 16px;
        }
 
        .tweet-meta-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
 
        .tweet-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #3490dc;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            flex-shrink: 0;
        }
 
        .tweet-author-info .username {
            font-weight: bold;
            font-size: 15px;
            color: #3490dc;
        }
 
        .tweet-author-info .time {
            font-size: 12px;
            color: #999;
            margin-top: 2px;
        }
 
        .tweet-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #111;
            line-height: 1.4;
        }
 
        .tweet-content {
            color: #444;
            font-size: 15px;
            line-height: 1.65;
        }
 
        .stats-bar {
            display: flex;
            gap: 6px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
        }
 
        .stat-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 20px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            font-size: 13px;
            color: #555;
            transition: all 0.15s;
            text-decoration: none;
        }
 
        .stat-btn:hover {
            background: #f0f2f5;
            border-color: #bbb;
        }
 

        .stat-btn.liked    { background: #fff0f0; border-color: #e74c3c; color: #e74c3c; }
        .stat-btn.disliked { background: #fff5f0; border-color: #e67e22; color: #e67e22; }
        .stat-btn.saved    { background: #f0f7ff; border-color: #3490dc; color: #3490dc; }
        .stat-btn.reposted { background: #f0fff4; border-color: #27ae60; color: #27ae60; }
 
        .stat-btn form { display: inline; }
 
        .stat-btn button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            color: inherit;
            padding: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
 
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
 
        .section-header h3 {
            font-size: 17px;
            color: #222;
        }
 
        .btn-primary {
            background: #3490dc;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.15s;
        }
 
        .btn-primary:hover { background: #2779bd; }
 
        .btn-outline {
            background: white;
            color: #3490dc;
            border: 1px solid #3490dc;
            padding: 7px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.15s;
        }
 
        .btn-outline:hover {
            background: #3490dc;
            color: white;
        }
 
        .comment-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }
 
        .comment-card .comment-username {
            font-weight: bold;
            color: #3490dc;
            font-size: 13px;
            margin-bottom: 5px;
        }
 
        .comment-card .comment-content {
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 6px;
        }
 
        .comment-card .comment-meta {
            font-size: 11px;
            color: #aaa;
        }
 
        /* Reply preview indent */
        .reply-preview {
            background: #f9f9f9;
            border-left: 3px solid #3490dc;
            padding: 8px 12px;
            border-radius: 5px;
            margin-top: 8px;
            margin-left: 18px;
            font-size: 13px;
        }
 
        .reply-preview .reply-username {
            font-weight: bold;
            color: #3490dc;
            font-size: 12px;
            margin-bottom: 3px;
        }
 
        .reply-preview .reply-content {
            color: #555;
        }

        .see-all-comments {
            text-align: center;
            padding: 12px;
            background: white;
            border: 1px dashed #ddd;
            border-radius: 10px;
            margin-top: 6px;
        }
 
        .see-all-comments a {
            color: #3490dc;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }
 
        .see-all-comments a:hover { text-decoration: underline; }
 
        .empty-comments {
            text-align: center;
            color: #aaa;
            font-size: 14px;
            padding: 24px;
            background: white;
            border-radius: 10px;
            border: 1px solid #eee;
        }
 
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div class="title">📄 Tweet Detail</div>
    <div></div>
</div>
 
<div class="container">
 
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
 
    <div class="tweet-card">
        <div class="tweet-meta-top">
            <div class="tweet-avatar">
                {{ strtoupper(substr($tweet->user?->username ?? 'U', 0, 1)) }}
            </div>
            <div class="tweet-author-info">
                <div class="username">{{ $tweet->user?->username ?? 'Unknown' }}</div>
                <div class="time">{{ $tweet->created_at->diffForHumans() }}</div>
            </div>
        </div>
 
        <div class="tweet-title">{{ $tweet->title }}</div>
        <div class="tweet-content">{{ $tweet->content }}</div>
 
        <div class="stats-bar">
 
            {{-- Like --}}
            <form method="POST" action="/tweets/{{ $tweet->id }}/like"
                  class="stat-btn {{ $tweet->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}">
                @csrf
                <button type="submit">👍 {{ $tweet->likes->count() }} Like</button>
            </form>
 
            {{-- Dislike --}}
            <form method="POST" action="/tweets/{{ $tweet->id }}/dislike"
                  class="stat-btn {{ $tweet->dislikes->contains('user_id', auth()->id()) ? 'disliked' : '' }}">
                @csrf
                <button type="submit">👎 {{ $tweet->dislikes->count() }} Dislike</button>
            </form>
 
            {{-- Repost --}}
            <form method="POST" action="/tweets/{{ $tweet->id }}/repost"
                  class="stat-btn {{ $tweet->reposts->contains('user_id', auth()->id()) ? 'reposted' : '' }}">
                @csrf
                <button type="submit">🔁 {{ $tweet->reposts->count() }} Repost</button>
            </form>
 
            {{-- Bookmark --}}
            @php
                $isBookmarked = $tweet->bookmarks->contains('user_id', auth()->id());
            @endphp
            <span class="stat-btn {{ $isBookmarked ? 'saved' : '' }}">
                @if($isBookmarked)
                    <form method="POST" action="{{ route('bookmarks.destroy', $tweet->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">🔖 Saved</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('bookmarks.store') }}">
                        @csrf
                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                        <button type="submit">🔖 Save</button>
                    </form>
                @endif
            </span>
 
            <a href="{{ route('comments.index', $tweet->id) }}" class="stat-btn">
                💬 {{ $tweet->comments->count() }} Comments
            </a>
 
        </div>
    </div>

    <div class="card">
        <div class="section-header">
            <h3>💬 Comments ({{ $tweet->comments->count() }})</h3>
            <a href="{{ route('comments.create', $tweet->id) }}" class="btn-primary">+ Add Comment</a>
        </div>

        @forelse($tweet->comments->whereNull('parent_id')->take(3) as $comment)
            <div class="comment-card">
                <div class="comment-username">{{ $comment->user?->username ?? 'Unknown' }}</div>
                <div class="comment-content">{{ $comment->content }}</div>
                <div class="comment-meta">{{ $comment->created_at->diffForHumans() }}</div>
 
                @if($comment->replies->count() > 0)
                    <div class="reply-preview">
                        <div class="reply-username">{{ $comment->replies->first()->user?->username ?? 'Unknown' }}</div>
                        <div class="reply-content">{{ $comment->replies->first()->content }}</div>
                    </div>
                    @if($comment->replies->count() > 1)
                        <div style="font-size:12px; color:#3490dc; margin-top:6px; margin-left:18px;">
                            +{{ $comment->replies->count() - 1 }} more repl{{ $comment->replies->count() - 1 > 1 ? 'ies' : 'y' }}
                        </div>
                    @endif
                @endif
            </div>
        @empty
            <div class="empty-comments">No comments yet. Be the first! 👇</div>
        @endforelse
 
        @if($tweet->comments->whereNull('parent_id')->count() > 3)
            <div class="see-all-comments">
                <a href="{{ route('comments.index', $tweet->id) }}">
                    View all {{ $tweet->comments->whereNull('parent_id')->count() }} comments →
                </a>
            </div>
        @elseif($tweet->comments->count() > 0)
            <div class="see-all-comments">
                <a href="{{ route('comments.index', $tweet->id) }}">
                    Manage comments (edit, delete, reply) →
                </a>
            </div>
        @endif
 
    </div>
 
</div>
</body>