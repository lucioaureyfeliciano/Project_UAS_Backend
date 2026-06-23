<!DOCTYPE html>
<html>

<head>
    <title>Search Users</title>

    <style>
        body {
            font-family: Arial;
            background: #f3f3f3;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .container {
            width: 75%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .search-box {
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
        }

        .search-input {
            width: 80%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        .search-btn {
            padding: 12px 20px;
            border: none;
            background: #3490dc;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #2779bd;
        }

        .user-card {
            background: #b4cde5;
            border: 1px solid #444;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 15px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            transition: .2s;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .avatar {
            width: 85px;
            height: 85px;

            border-radius: 50%;

            background: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;

            border: 2px solid rgba(255, 255, 255, .8);
        }

        .username-link {
            text-decoration: none;
            color: black;
        }

        .username-link:hover {
            color: #2f7cc2;
        }

        .username {
            margin: 0;
            font-size: 24px;
        }

        .bio {
            margin-top: 6px;
            color: #555;
        }

        .follow-btn {
            border: none;
            border-radius: 25px;
            padding: 12px 24px;
            cursor: pointer;
            color: white;
            font-size: 14px;
        }

        .follow {
            background: #3490dc;
        }

        .following {
            background: #95a5a6;
        }

        .section-title {
            margin-bottom: 20px;
            font-size: 28px;
        }

        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;

            width: 45px;
            height: 45px;

            border: none;
            border-radius: 50%;

            background: #3490dc;
            color: white;

            font-size: 20px;

            cursor: pointer;

            box-shadow: 0 4px 10px rgba(0, 0, 0, .15);

            z-index: 999;
        }

        #scrollTopBtn:hover {
            background: #2779bd;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .filter-tab {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 20px;
            background: white;
            color: black;
            font-weight: bold;
        }

        .filter-tab.active {
            background: #3490dc;
            color: white;
        }

        .tweet-card {
            background: white;
            padding: 18px;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .tweet-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tweet-content {
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .tweet-info {
            color: #666;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .tweet-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .reaction-btn {
            background: white;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        .mention-link {
            color: #3490dc;
            font-weight: bold;
            text-decoration: none;
        }

        .mention-link:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    @include('components.toast')

    <div class="navbar">

        <a href="/dashboard" class="back-btn">
            ← Back
        </a>

    </div>

    <div class="container">

        <div class="search-box">

            <form method="GET">

                <input type="text" name="search" class="search-input" placeholder="Search username or tweets"
                    value="{{ $keyword }}">

                <button type="submit" class="search-btn">
                    Search
                </button>

            </form>

        </div>

        @if($keyword)

            <div class="filter-tabs">

                <a href="?search={{ $keyword }}&type=all" class="filter-tab {{ $type == 'all' ? 'active' : '' }}">
                    All
                </a>

                <a href="?search={{ $keyword }}&type=users" class="filter-tab {{ $type == 'users' ? 'active' : '' }}">
                    Users
                </a>

                <a href="?search={{ $keyword }}&type=tweets" class="filter-tab {{ $type == 'tweets' ? 'active' : '' }}">
                    Tweets
                </a>

            </div>

        @endif

        @if($keyword)

            <h2 class="section-title">
                Search Results
            </h2>

        @endif

        @if($type == 'all' || $type == 'users')
            @forelse($users as $user)

                @php

                    $isFollowing = \App\Models\Follow::where(
                        'follower_id',
                        auth()->id()
                    )
                        ->where(
                            'following_id',
                            $user->id
                        )
                        ->exists();

                @endphp

                <div class="user-card">

                    <div class="user-info">

                        <a href="{{ route('profile.show', $user->username) }}" class="username-link">

                            <div class="avatar">
                                👤
                            </div>

                        </a>

                        <div>

                            <a href="{{ route('profile.show', $user->username) }}" class="username-link">

                                <h3 class="username">
                                    {{ $user->username }}
                                </h3>

                            </a>

                            <div class="bio">

                                {{ $user->bio ?: 'No description yet.' }}

                            </div>

                        </div>

                    </div>

                    @if(auth()->id() != $user->id)

                        <form method="POST" action="{{ route('follow', $user->id) }}">

                            @csrf

                            <button type="submit" class="follow-btn {{ $isFollowing ? 'following' : 'follow' }}">

                                {{ $isFollowing ? 'Following' : 'Follow' }}

                            </button>

                        </form>

                    @endif

                </div>

            @empty

                @if($keyword)

                    <p>
                        No users found.
                    </p>

                @endif

            @endforelse
        @endif

        @if($type == 'all' || $type == 'tweets')

            @if($tweets->count())

                <h2 class="section-title">
                    Tweets
                </h2>

                @foreach($tweets as $tweet)

                    <div class="tweet-card">

                        <div class="tweet-info">

                            <a href="{{ route('profile.show', $tweet->user->username) }}"
                                style="text-decoration:none;color:#3490dc;font-weight:bold;">

                                {{ $tweet->user->username }}

                            </a>

                            •

                            {{ $tweet->created_at->diffForHumans() }}

                        </div>

                        <div class="tweet-title">
                            {{ $tweet->title }}
                        </div>

                        <div class="tweet-content">
                            {!! preg_replace(
                            '/@([a-zA-Z0-9_]+)/',
                            '<a href="/user/$1" class="mention-link">@$1</a>',
                            e($tweet->content)
                        ) !!}
                        </div>

                        <div class="tweet-actions">

                            <span class="reaction-btn">
                                👍 {{ $tweet->likes->count() }}
                            </span>

                            <span class="reaction-btn">
                                👎 {{ $tweet->dislikes->count() }}
                            </span>

                            <span class="reaction-btn">
                                🔁 {{ $tweet->reposts->count() }}
                            </span>

                            <a href="{{ route('tweets.show', $tweet->id) }}" class="reaction-btn comment-btn"
                                style="text-decoration:none;">

                                💬 {{ $tweet->comments->count() }}

                            </a>

                            <form action="{{ route('bookmarks.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                <button type="submit" class="reaction-btn" style="color:#3490dc; background:white; font-size:14px;">
                                    🔖 Bookmark
                                </button>
                            </form>

                        </div>

                    </div>

                @endforeach

            @elseif($keyword)

                <p>No tweets found.</p>

            @endif

        @endif

    </div>

    <button id="scrollTopBtn" onclick="scrollToTop()">
        ↑
    </button>

    <script>

        window.onscroll = function () {

            const button =
                document.getElementById("scrollTopBtn");

            if (
                document.body.scrollTop > 300 ||
                document.documentElement.scrollTop > 300
            ) {

                button.style.display = "block";

            } else {

                button.style.display = "none";

            }

        };

        function scrollToTop() {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        }

    </script>

</body>

</html>
