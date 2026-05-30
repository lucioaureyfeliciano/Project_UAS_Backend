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
    </div>
 
    @forelse($bookmarks as $bookmark)
        <div class="bookmark-card">
 
            <div class="tweet-title">{{ $bookmark->tweet?->title ?? '[Tweet deleted]' }}</div>
            <div class="tweet-content">{{ $bookmark->tweet?->content ?? '-' }}</div>
            <div class="tweet-meta">
                By <strong>{{ $bookmark->tweet?->user?->username ?? 'Unknown' }}</strong>
                · Bookmarked {{ $bookmark->created_at->diffForHumans() }}
            </div>
 
            <div class="bookmark-actions">
                <form action="{{ route('bookmarks.destroy', $bookmark->tweet_id) }}" method="POST"
                    onsubmit="return confirm('Hapus bookmark ini?')">
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
                <p>Belum ada bookmark. Simpan tweet favoritmu!</p>
            </div>
        </div>
    @endforelse
 
    {{ $bookmarks->links() }}
 
</div>
 
</body>
</html>