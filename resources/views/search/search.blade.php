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

        .icon-img {
            width: 20px;
            height: 20px;
            object-fit: contain;
            display: inline-block;
            vertical-align: middle;
        }

        .like-btn {
            color: #3490dc;
        }

        .like-btn:hover {
            background: #e8f5ff;
            border-color: #3490dc;
        }

        .like-btn.active {
            background: #dbeeff;
            border-color: #3490dc;
        }

        .dislike-btn {
            color: #e74c3c;
        }

        .dislike-btn:hover {
            background: #ffe5e5;
            border-color: #ff6b6b;
        }

        .dislike-btn.active {
            background: #ffe5e5;
            border-color: #e74c3c;
        }

        .repost-btn {
            color: #6c5ce7;
        }

        .repost-btn:hover {
            background: #f0e6ff;
            border-color: #9b59b6;
        }

        .repost-btn.active {
            background: #ede9fd;
            border-color: #6c5ce7;
        }

        .bookmark-btn {
            color: #ff9f43;
        }

        .bookmark-btn:hover {
            background: #fff4e0;
            border-color: #ff9f43;
        }

        .bookmark-btn.active {
            background: #dbeeff;
            border-color: #3490dc;
        }

        .share-modal {
            display: none;
            width: 100%;
            flex-basis: 100%;
            margin-top: 12px;
            padding: 14px;
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-sizing: border-box;
        }

        .share-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #6c5ce7;
        }

        .share-select,
        .share-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            font-size: 13px;
            box-sizing: border-box;
            background: white;
        }

        .share-select {
            margin-bottom: 10px;
        }

        .share-textarea {
            resize: none;
            min-height: 70px;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .share-textarea:focus,
        .share-select:focus {
            outline: none;
            border-color: #6c5ce7;
        }

        .share-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .share-send-btn {
            background: #6c5ce7;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .share-send-btn:hover {
            background: #5a4fcf;
        }

        .share-cancel-btn {
            background: #f1f1f1;
            color: #555;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .share-cancel-btn:hover {
            background: #e0e0e0;
        }


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

                        @php
                            $userLiked = $tweet->likes->contains('user_id', auth()->id());
                            $userDisliked = $tweet->dislikes->contains('user_id', auth()->id());
                            $userReposted = $tweet->reposts->contains('user_id', auth()->id());

                            $userSaved = \App\Models\Bookmark::where('user_id', auth()->id())
                                ->where('tweet_id', $tweet->id)
                                ->exists();
                        @endphp

                        <div class="tweet-actions">

                            <button class="like-btn reaction-btn {{ $userLiked ? 'active' : '' }}" data-id="{{ $tweet->id }}"
                                data-liked="{{ $userLiked ? '1' : '0' }}">
                                <img src="{{ asset('image/' . ($userLiked ? 'liked.png' : 'like.png')) }}" class="icon-img"
                                    alt="Like">
                                <span id="like-count-{{ $tweet->id }}">{{ $tweet->likes->count() }}</span>
                            </button>

                            <button type="button" class="dislike-btn reaction-btn {{ $userDisliked ? 'active' : '' }}"
                                data-id="{{ $tweet->id }}">
                                <img src="{{ asset('image/' . ($userDisliked ? 'liked.png' : 'like.png')) }}" class="icon-img"
                                    alt="Dislike" style="transform: scaleY(-1);">
                                <span id="dislike-count-{{ $tweet->id }}">{{ $tweet->dislikes->count() }}</span>
                            </button>

                            <button type="button" class="repost-btn reaction-btn {{ $userReposted ? 'active' : '' }}"
                                data-id="{{ $tweet->id }}">
                                <img src="{{ asset('image/repost.png') }}" class="icon-img" alt="Repost">
                                <span id="repost-count-{{ $tweet->id }}">{{ $tweet->reposts->count() }}</span>
                            </button>

                            <a href="{{ route('tweets.show', $tweet->id) }}" class="reaction-btn comment-btn"
                                style="text-decoration:none;">
                                <img src="{{ asset('image/comment.png') }}" class="icon-img" alt="Comment">
                                {{ $tweet->comments->count() }}
                            </a>

                            <form action="{{ route('bookmarks.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                <button type="submit" class="reaction-btn bookmark-btn {{ $userSaved ? 'active' : '' }}">
                                    <img src="{{ asset($userSaved ? 'image/saved.png' : 'image/save.png') }}" class="icon-img"
                                        alt="Bookmark">
                                    {{ $userSaved ? 'Saved' : 'Save' }}
                                </button>
                            </form>

                            <button class="reaction-btn share-btn" onclick="toggleShareModal('share-tw-{{ $tweet->id }}')">
                                <img src="{{ asset('image/share.png') }}" class="icon-img" alt="Share">
                                Share
                            </button>

                            <div id="share-tw-{{ $tweet->id }}" class="share-modal">
                                <div class="share-header">
                                    <img src="{{ asset('image/share.png') }}" class="icon-img" alt="Share">
                                    Share to Message
                                </div>

                                <form method="POST" action="{{ route('messages.share') }}">
                                    @csrf

                                    <select name="receiver_id" required class="share-select">
                                        <option value="">Select user...</option>

                                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->orderBy('username')->get() as $u)
                                            <option value="{{ $u->id }}">
                                                {{ $u->username }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <textarea name="message" class="share-textarea"
                                        placeholder="Add a message...">[TWEET:{{ $tweet->id }}]</textarea>

                                    <div class="share-actions">
                                        <button type="button" class="share-cancel-btn"
                                            onclick="toggleShareModal('share-tw-{{ $tweet->id }}')">Cancel</button>

                                        <button type="submit" class="share-send-btn">Send</button>
                                    </div>
                                </form>
                            </div>

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

        document.querySelectorAll('.dislike-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tweetId = this.dataset.id;
                fetch(`/tweets/${tweetId}/dislike`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById(`dislike-count-${tweetId}`).innerText = data.count;
                    })
                    .catch(err => console.log(err));
            });
        });

        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tweetId = this.dataset.id;
                fetch(`/tweets/${tweetId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById(`like-count-${tweetId}`).innerText = data.count;
                    })
                    .catch(err => console.log(err));
            });
        });

        document.querySelectorAll('.repost-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tweetId = this.dataset.id;
                fetch(`/tweets/${tweetId}/repost`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById(`repost-count-${tweetId}`).innerText = data.count;
                    });
            });
        });

        function toggleShareModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

    </script>

</body>

</html>
