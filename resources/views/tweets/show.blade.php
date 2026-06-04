<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $tweet->title }}</title>
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

        .back-btn{
            color:white;
            text-decoration:none;
            font-weight:bold;
        }

        .comment-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
        }

        .comment-username {
            font-weight: bold;
            color: #3490dc;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .comment-content {
            color: #333;
            line-height: 1.5;
            margin-bottom: 6px;
        }

        .comment-meta {
            font-size: 12px;
            color: #999;
        }

        .comment-actions {
            margin-top: 8px;
            display: flex;
            gap: 8px;
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

        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-edit:hover {
            background: #d68910;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .reply-card {
            background: #f9f9f9;
            border-left: 3px solid #3490dc;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 8px;
            margin-left: 20px;
        }

        .reply-btn {
            background: transparent;
            border: 1px solid #3490dc;
            color: #3490dc;
            padding: 4px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }

        .reply-form {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
            border-left: 3px solid #e0e0e0;
        }

        .reply-send-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 6px;
        }

        .reply-cancel-btn {
            background: #f5c2c7;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 6px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            resize: none;
        }

        .submit-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 9px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div>📄 Tweet Detail</div>
    <div></div>
</div>

<div class="container">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <a href="{{ route('comments.create', $tweet->id) }}"
        class="submit-btn"
        style="text-decoration:none; display:inline-block;">
            💬 Add Comment
        </a>
    </div>

    {{-- Comment List --}}
    <div class="card">
        <h3>Comments ({{ $tweet->comments->count() }})</h3>
        @forelse($tweet->comments as $comment)
            <div class="comment-card">
                <div class="comment-username">{{ $comment->user?->username ?? 'Unknown' }}</div>
                <div class="comment-content">{{ $comment->content }}</div>
                <div class="comment-meta">{{ $comment->created_at->diffForHumans() }}</div>

                <div style="margin-top:8px;">
                    <button onclick="toggleReply('reply-{{ $comment->id }}')" class="reply-btn">↩ Reply</button>
                </div>

                <div id="reply-{{ $comment->id }}" class="reply-form">
                    <form method="POST" action="{{ route('comments.store', $tweet->id) }}">
                        @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2"  placeholder="Tulis balasan..." required ></textarea>
                            <button type="submit" class="reply-send-btn">Send </button>
                            <button type="button" onclick="toggleReply('reply-{{ $comment->id }}')" class="reply-cancel-btn">Cancel</button>
                    </form>
                </div>

                @foreach($comment->replies as $reply)
                    <div class="reply-card">
                        <div class="comment-username" style="font-size:13px;">{{ $reply->user?->username ?? 'Unknown' }}</div>
                        <div style="font-size:13px; color:#333;">{{ $reply->content }}</div>
                        <div class="comment-meta">{{ $reply->created_at->diffForHumans() }}</div>
         
                        @if($reply->user_id === auth()->id())
                            <div class="comment-actions">
                                <a href="{{ route('comments.edit', $reply->id) }}" class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('comments.destroy', $reply->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this reply?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @empty
            <p style="color:#888; text-align:center;">No comments yet.</p>
        @endforelse
    </div>

</div>
<script>
function toggleReply(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
</body>
</html>