<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments — {{ $tweet->title }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
 
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
 
        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
 
        .back-btn:hover { opacity: 0.8; }
 
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
 
        .tweet-ref-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 16px 20px;
            margin-bottom: 16px;
            border-left: 4px solid #3490dc;
        }
 
        .tweet-ref-card .tweet-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #111;
        }
 
        .tweet-ref-card .tweet-content {
            font-size: 13px;
            color: #555;
            line-height: 1.5;
            margin-bottom: 6px;
        }
 
        .tweet-ref-card .tweet-meta {
            font-size: 12px;
            color: #999;
        }
 
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
 
        .section-header h2 {
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
 
        .btn-edit {
            background: #f39c12;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.15s;
        }
 
        .btn-edit:hover { background: #d68910; }
 
        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.15s;
        }
 
        .btn-delete:hover { background: #c0392b; }
 
        .btn-cancel {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.15s;
        }
 
        .btn-cancel:hover { background: #ccc; }
 
        .reply-btn {
            background: transparent;
            border: 1px solid #3490dc;
            color: #3490dc;
            padding: 4px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.15s;
        }
 
        .reply-btn:hover {
            background: #3490dc;
            color: white;
        }
 
        .comment-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }
 
        .comment-username {
            font-weight: bold;
            color: #3490dc;
            font-size: 13px;
            margin-bottom: 5px;
        }
 
        .comment-content {
            color: #333;
            font-size: 14px;
            line-height: 1.55;
            margin-bottom: 6px;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
        }
 
        .comment-meta {
            font-size: 11px;
            color: #aaa;
            margin-bottom: 10px;
        }
 
        .comment-actions {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-wrap: wrap;
        }
 
        .edit-modal {
            display: none;
            margin-top: 12px;
            padding: 12px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
 
        .edit-modal textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
            resize: none;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
 
        .edit-modal .edit-actions {
            display: flex;
            gap: 7px;
            margin-top: 8px;
        }
 
        .reply-form {
            display: none;
            margin-top: 10px;
            padding: 10px 12px;
            background: #f9f9f9;
            border-left: 3px solid #3490dc;
            border-radius: 0 8px 8px 0;
        }
 
        .reply-form textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
            resize: none;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
 
        .reply-form .reply-actions {
            display: flex;
            gap: 7px;
            margin-top: 7px;
        }
 
        .replies {
            margin-top: 10px;
            margin-left: 20px;
        }
 
        .reply-card {
            background: #f9f9f9;
            border-left: 3px solid #3490dc;
            padding: 10px 14px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 8px;
            overflow: hidden;
        }
 
        .reply-card .reply-username {
            font-weight: bold;
            color: #3490dc;
            font-size: 12px;
            margin-bottom: 4px;
        }
 
        .reply-card .reply-content {
            color: #444;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 4px;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
        }
 
        .reply-card .reply-meta {
            font-size: 11px;
            color: #aaa;
            margin-bottom: 8px;
        }
 
        .reply-card .reply-actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }
 
        .edit-reply-modal {
            display: none;
            margin-top: 8px;
            padding: 10px;
            background: #fff;
            border-radius: 7px;
            border: 1px solid #ddd;
        }
 
        .edit-reply-modal textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
            resize: none;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
 
        .edit-reply-modal .edit-actions {
            display: flex;
            gap: 7px;
            margin-top: 7px;
        }
 
        .empty-state {
            text-align: center;
            color: #aaa;
            font-size: 14px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            border: 1px solid #eee;
        }
        .comment-username a,
        .reply-username a {
            color: #3490dc;
            text-decoration: none;
        }

        .comment-username a:hover,
        .reply-username a:hover {
            text-decoration: underline;
        }

        .comment-sort {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }

        .comment-sort-label {
            font-size: 13px;
            color: #888;
        }

        .sort-tab {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            text-decoration: none;
            background: white;
            color: #555;
            border: 1px solid #ddd;
            transition: 0.2s;
        }

        .sort-tab:hover {
            background: #f5f5f5;
        }

        .sort-tab.active {
            background: #3490dc;
            color: white;
            border-color: #3490dc;
        }

        .pinned-label {
            font-size: 11px;
            color: #f39c12;
            font-weight: bold;
        }

        .pin-btn {
            border: 1px solid #f39c12;
            color: #f39c12;
            background: transparent;
            padding: 4px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: 0.2s;
        }

        .pin-btn:hover {
            background: #fff4e6;
        }

        .pin-btn.active {
            background: #f39c12;
            color: white;
        }

        .reply-counter {
            text-align: right;
            font-size: 11px;
            color: #888;
            margin-top: 4px;
        }

        .reply-counter.limit {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
 
<div class="navbar">
    <a href="{{ route('tweets.show', $tweet->id) }}" class="back-btn">← Back to Tweet</a>
    <div>💬 Comments</div>
    <div></div>
</div>
 
<div class="container">
 
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
 
    <div class="tweet-ref-card">
        <div class="tweet-title">{{ $tweet->title }}</div>
        <div class="tweet-content">{{ Str::limit($tweet->content, 120) }}</div>
        <div class="tweet-meta">
            By <strong>{{ $tweet->user?->username ?? 'Unknown' }}</strong>
            · {{ $tweet->created_at->diffForHumans() }}
        </div>
    </div>
 
    <div class="comment-sort">
        <span class="comment-sort-label">Sort:</span>

        @foreach(['newest'=>'Newest','oldest'=>'Oldest','popular'=>'Most Popular'] as $key => $label)
            <a href="?sort={{ $key }}"
            class="sort-tab {{ ($sort ?? 'newest') === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="section-header">
        <h2>Comments ({{ $comments->count() }})</h2>
        <a href="{{ route('comments.create', $tweet->id) }}" class="btn-primary">+ Add Comment</a>
    </div>
 
    @forelse($comments as $comment)
        <div class="comment-card">
 
            <div class="comment-username">
                <a href="{{ route('user.profile', $comment->user?->username) }}">
                    {{ $comment->user?->username ?? 'Unknown' }}
                </a>
            </div>
            <div class="comment-content">{{ $comment->content }}</div>
            <div class="comment-meta">{{ $comment->created_at->diffForHumans() }}</div>
 
            <div class="comment-actions">
 
                @if($comment->is_pinned)
                        <span class="pinned-label">📌 Pinned</span>
                @endif

                @if(auth()->id() === $tweet->user_id && is_null($comment->parent_id))
                    <form method="POST" action="{{ route('comments.pin', [$tweet->id, $comment->id]) }}">
                        @csrf
                        <button type="submit" class="pin-btn {{ $comment->is_pinned ? 'active' : '' }}">
                            {{ $comment->is_pinned ? '📌 Unpin' : '📌 Pin' }}
                        </button>
                    </form>
                @endif

                <button onclick="toggleEl('reply-{{ $comment->id }}')" class="reply-btn">↩ Reply</button>
 
                @if($comment->user_id === auth()->id())
                    <button onclick="toggleEl('edit-comment-{{ $comment->id }}')" class="btn-edit">Edit</button>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                          onsubmit="return confirm('Delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                @endif
 
            </div>
 
            @if($comment->user_id === auth()->id())
                <div class="edit-modal" id="edit-comment-{{ $comment->id }}">
                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="content" rows="3">{{ $comment->content }}</textarea>
                        <div class="edit-actions">
                            <button type="submit" class="btn-primary">Save</button>
                            <button type="button" onclick="toggleEl('edit-comment-{{ $comment->id }}')" class="btn-cancel">Cancel</button>
                        </div>
                    </form>
                </div>
            @endif
 
            <div class="reply-form" id="reply-{{ $comment->id }}">
                <form method="POST" action="{{ route('comments.store', $tweet->id) }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea
                        class="reply-box"
                        name="content"
                        rows="2"
                        maxlength="280"
                        placeholder="Write a reply..."
                        required></textarea>

                    <div class="reply-counter">0/280</div>
                    <div class="reply-actions">
                        <button type="submit" class="btn-primary">Send</button>
                        <button type="button" onclick="toggleEl('reply-{{ $comment->id }}')" class="btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
 
            @if($comment->replies->count() > 0)
                <div class="replies">
                    @foreach($comment->replies as $reply)
                        <div class="reply-card">
 
                            <div class="reply-username">
                                <a href="{{ route('user.profile', $reply->user?->username) }}">
                                    {{ $reply->user?->username ?? 'Unknown' }}
                                </a>
                            </div>
                            <div class="reply-content">{{ $reply->content }}</div>
                            <div class="reply-meta">{{ $reply->created_at->diffForHumans() }}</div>
 
                            {{-- Reply actions (hanya pemilik) --}}
                            @if($reply->user_id === auth()->id())
                                <div class="reply-actions">
                                    <button onclick="toggleEl('edit-reply-{{ $reply->id }}')" class="btn-edit">Edit</button>
                                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this reply?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                </div>
 
                                {{-- Inline edit reply --}}
                                <div class="edit-reply-modal" id="edit-reply-{{ $reply->id }}">
                                    <form action="{{ route('comments.update', $reply->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" rows="2">{{ $reply->content }}</textarea>
                                        <div class="edit-actions">
                                            <button type="submit" class="btn-primary">Save</button>
                                            <button type="button" onclick="toggleEl('edit-reply-{{ $reply->id }}')" class="btn-cancel">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
 
                        </div>
                    @endforeach
                </div>
            @endif
 
        </div>
    @empty
        <div class="empty-state">No comments yet. Be the first! 👇</div>
    @endforelse
 
</div>
 
<script>
    function toggleEl(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = el.style.display === 'block' ? 'none' : 'block';
    }
</script>
<script>
document.querySelectorAll('.reply-box').forEach(box => {
    const counter = box.parentElement.querySelector('.reply-counter');

    box.addEventListener('input', () => {
        const len = box.value.length;
        counter.innerText = `${len}/280`;

        if(len >= 250){
            counter.classList.add('limit');
        } else {
            counter.classList.remove('limit');
        }
    });

});
</script>
</body>
</html>