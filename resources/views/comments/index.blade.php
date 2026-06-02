<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
 
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }
 
        .navbar {
            background: #3490dc;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
 
        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
 
        .container {
            width: 650px;
            margin: 25px auto;
        }
 
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }
 
        .tweet-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }
 
        .tweet-content {
            color: #444;
            margin-bottom: 6px;
            line-height: 1.5;
        }
 
        .tweet-meta {
            font-size: 13px;
            color: #888;
        }
 
        .comment-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
        }
 
        .comment-username {
            font-weight: bold;
            color: #3490dc;
            margin-bottom: 5px;
        }
 
        .comment-content {
            color: #333;
            line-height: 1.5;
            margin-bottom: 8px;
        }
 
        .comment-meta {
            font-size: 12px;
            color: #999;
        }
 
        .comment-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
 
        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }
 
        .btn-delete:hover {
            background: #c0392b;
        }
 
        .btn-edit {
            background: #f39c12;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
        }
 
        .btn-edit:hover {
            background: #d68910;
        }
 
        .add-comment-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3490dc;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 15px;
        }
 
        .add-comment-btn:hover {
            background: #2779bd;
        }
 
        .replies {
            margin-left: 30px;
            margin-top: 10px;
        }
 
        .reply-card {
            background: #f9f9f9;
            border-left: 3px solid #3490dc;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 8px;
        }
 
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #a3cfbb;
        }
 
        h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
 
<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div>💬 Comments</div>
    <div></div>
</div>
 
<div class="container">
 
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
 
    {{-- Tweet Detail --}}
    <div class="card">
        <div class="tweet-title">{{ $tweet->title }}</div>
        <div class="tweet-content">{{ $tweet->content }}</div>
        <div class="tweet-meta">
            By <strong>{{ $tweet->user?->username ?? 'Unknown' }}</strong>
            · {{ $tweet->created_at->diffForHumans() }}
        </div>
    </div>
 
    {{-- Tombol Add Comment --}}
    <a href="{{ route('comments.create', $tweet->id) }}" class="add-comment-btn">
        + Add Comment
    </a>
 
    {{-- Daftar Comments --}}
    <div>
        <h2>Comments ({{ $comments->count() }})</h2>
 
        @forelse($comments as $comment)
            <div class="comment-card">
                <div class="comment-username">{{ $comment->user?->username ?? 'Unknown' }}</div>
                <div class="comment-content">{{ $comment->content }}</div>
                <div class="comment-meta">{{ $comment->created_at->diffForHumans() }}</div>
 
                @if($comment->user_id === auth()->id())
                    <div class="comment-actions">
                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                            onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                @endif
 
                {{-- Replies --}}
                @if($comment->replies->count() > 0)
                    <div class="replies">
                        @foreach($comment->replies as $reply)
                            <div class="reply-card">
                                <div class="comment-username">{{ $reply->user?->username ?? 'Unknown' }}</div>
                                <div class="comment-content">{{ $reply->content }}</div>
                                <div class="comment-meta">{{ $reply->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="card">
                <p style="color:#888; text-align:center;">Belum ada komentar👇</p>
            </div>
        @endforelse
    </div>
 
</div>
 
</body>
</html>