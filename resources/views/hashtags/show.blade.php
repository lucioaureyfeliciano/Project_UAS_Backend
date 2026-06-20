<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>#{{ $hashtag->name }}</title>
<style>

    body {
        font-family: Arial;
        background: #f4f4f4;
        margin: 0;
    }

    .navbar {
        background: #3490dc;
        color: white;
        padding: 15px 20px;
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
        margin: 20px auto;
    }

    .hashtag-header {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .hashtag-title {
        font-size: 32px;
        font-weight: bold;
        color: #3490dc;
        margin-bottom: 10px;
    }

    .hashtag-info {
        color: #777;
        font-size: 14px;
    }

    .tweet-card {
        background: white;
        border-radius: 15px;
        padding: 18px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: 0.2s;
    }

    .tweet-card:hover {
        transform: translateY(-2px);
    }

    .tweet-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #222;
    }

    .tweet-content {
        color: #444;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .tweet-meta {
        font-size: 13px;
        color: #888;
    }

    .empty-card {
        background: white;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        color: #666;
    }

    .hashtag-badge {
        display: inline-block;
        background: #e8f4ff;
        color: #3490dc;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        margin-top: 10px;
    }

</style>


</head>
<body>
@include('components.toast')


<div class="navbar">

    <a href="/dashboard" class="back-btn">
        ← Back
    </a>

    <div>
        Trending Hashtag
    </div>

</div>

<div class="container">

    <div class="hashtag-header">

        <div class="hashtag-title">
            #{{ $hashtag->name }}
        </div>

        <div class="hashtag-info">
            {{ $tweets->count() }} tweets using this hashtag
        </div>

        <div class="hashtag-badge">
            Trending Topic
        </div>

    </div>

    @forelse($tweets as $tweet)

        <div class="tweet-card">

            <div class="tweet-title">
                {{ $tweet->title }}
            </div>

            <div class="tweet-content">
                {{ $tweet->content }}
            </div>

            <div class="tweet-meta">
                By {{ $tweet->user?->username ?? 'Unknown User' }}
                ·
                {{ $tweet->created_at->diffForHumans() }}
            </div>

        </div>

    @empty

        <div class="empty-card">
            No tweets found for this hashtag.
        </div>

    @endforelse

</div>

</body>
</html>
