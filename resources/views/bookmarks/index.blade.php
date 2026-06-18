<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookmarks</title>
 
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
 
        .bookmark-card {
            background: white;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
        }
 
        .tweet-title {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 6px;
        }
 
        .tweet-content {
            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 1.5;
        }
 
        .tweet-meta {
            font-size: 12px;
            color: #999;
            margin-bottom: 12px;
        }
 
        .bookmark-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
 
        .btn-remove {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
 
        .btn-remove:hover {
            background: #c0392b;
        }
 
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #a3cfbb;
        }
 
        .alert-error {
            background: #fdf2f2;
            color: #721c24;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
 
        h2 { margin-top: 0; }
 
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
 
        .empty-state .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .bookmark-stats {
            font-size: 13px;
            color: #888;
            margin-bottom: 12px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-view {
            background: #3490dc;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-view:hover {
            background: #2779bd;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .search-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .search-input:focus {
            border-color: #3490dc;
        }

        .btn-search {
            background: #3490dc;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-search:hover {
            background: #2779bd;
        }

        mark{
            background:#fff3a0;
            padding:2px 4px;
            border-radius:4px;
        }

        .sort-row { 
            display:flex; 
            gap:8px; 
            align-items:center; 
            margin-top:12px; 
            flex-wrap:wrap; 
        }
        .sort-label { 
            font-size:13px; 
            color:#888; 
        }
        .sort-tab { 
            padding:5px 14px; 
            border-radius:20px; 
            font-size:12px; 
            text-decoration:none; 
            background:white; 
            color:#555; 
            border:1px solid #ddd; 
        }
        .sort-tab:hover { 
            background:#f5f5f5; 
        }
        .sort-tab.active { 
            background:#3490dc; 
            color:white; 
            border-color:#3490dc; 
        }
    </style>
</head>
<body>
 
<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div>🔖 Bookmarks</div>
    <div></div>
</div>
 
<div class="container">
 
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
 
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif
 
    <div class="card">
        <h2>Your Bookmarks ({{ $bookmarks->total() }})</h2>
        <form method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bookmark..." class="search-input">
            <button type="submit" class="btn-search">
                🔍 Search
            </button>
        </form>

        <div class="sort-row">
            <span class="sort-label">Sort:</span>
            @foreach(['newest' => 'Newest', 'oldest' => 'Oldest', 'tweet_date' => 'Tweet Date', 'author' => 'Author'] as $key => $label)
                <a href="?sort={{ $key }}&search={{ request('search') }}"
                    class="sort-tab {{ $sort === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
 
    @forelse($bookmarks as $bookmark)
        <div class="bookmark-card">

            @php
                $title = $bookmark->tweet?->title ?? '[Tweet deleted]';

                if(request('search')) {
                    $title = preg_replace(
                        '/(' . preg_quote(request('search'), '/') . ')/i',
                        '<mark>$1</mark>',
                        $title
                    );
                }
            @endphp

            <div class="tweet-title">{!! $title !!}</div>
            @php
                $content = $bookmark->tweet?->content ?? '-';

                if(request('search')) {
                    $content = preg_replace(
                        '/(' . preg_quote(request('search'), '/') . ')/i',
                        '<mark>$1</mark>',
                        $content
                    );
                }
            @endphp

            <div class="tweet-content">{!! $content !!}</div>         
            @php
                $username = $bookmark->tweet?->user?->username ?? 'Unknown';

                if(request('search')) {
                    $username = preg_replace(
                        '/(' . preg_quote(request('search'), '/') . ')/i',
                        '<mark>$1</mark>',
                        $username
                    );
                }
            @endphp

            <div class="tweet-meta">
                By <strong>{!! $username !!}</strong>
                · Bookmarked {{ $bookmark->created_at->diffForHumans() }}
            </div>

            @if($bookmark->tweet)
                <div class="bookmark-stats">
                    <span>👍 {{ $bookmark->tweet->likes->count() }}</span>
                    <span>👎 {{ $bookmark->tweet->dislikes->count() }}</span>
                    <span>🔁 {{ $bookmark->tweet->reposts->count() }}</span>
                    <span>💬 {{ $bookmark->tweet->comments->count() }}</span>
                </div>
            @endif

            <div class="bookmark-actions">
                @if($bookmark->tweet)
                    <a href="{{ route('tweets.show', $bookmark->tweet_id) }}"
                        style="background:#3490dc; color:white; padding:6px 14px; border-radius:6px; text-decoration:none; font-size:13px;">
                        📄 View Tweet
                    </a>
                @endif
                <form action="{{ route('bookmarks.destroy', $bookmark->tweet_id) }}" method="POST"
                    onsubmit="return confirm('Delete this bookmark?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-remove">🗑 Remove</button>
                </form>
            </div>
 
        </div>
    @empty
        <div class="card">
            <div class="empty-state">
                <div class="icon">🔖</div>
                <p>No bookmarks yet. Save your favorite tweets!</p>
            </div>
        </div>
    @endforelse
 
    {{ $bookmarks->links() }}
 
</div>
 
</body>
</html>