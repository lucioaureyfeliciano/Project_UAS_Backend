<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>

    <style>
        body {
            font-family: Arial;
            background: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #3b8edb;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        .container {
            width: 75%;
            max-width: 900px;
            margin: 35px auto;
        }

        .profile-card {
            background: #b4cde5;
            border-radius: 18px;
            padding: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            gap: 40px;
            flex-wrap: nowrap;
        }

        .profile-left h1 {
            margin: 0;
            font-size: 32px;
        }

        .profile-left {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .profile-user-info {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            width: 100%;
        }

        .profile-avatar {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            border: 2px solid rgba(255, 255, 255, .8);
            flex-shrink: 0;
        }

        .profile-details {
            flex: 1;
        }

        .username-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .description-section {
            margin-top: 5px;
            width: 100%;
        }

        .description-text {
            font-size: 16px;
            color: #444;
            line-height: 1.7;
            word-break: break-word;
            text-align: left;
            margin: 0;
        }

        .follow-btn-small {
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }

        .follow-btn-small:hover {
            transform: scale(1.05);
        }

        .edit-description-card {
            width: 100%;
            background: #b4cde5;
            color: white;
            border: none;
            border-radius: 18px;
            padding: 10px;
            margin-bottom: 30px;
            text-align: left;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 8px;
            box-sizing: border-box;
            transition: 0.2s;
        }

        .edit-description-card:hover {
            background: #2f7cc2;
            transform: translateY(-2px);
        }

        .edit-description-card:active {
            transform: translateY(0);
        }

        .edit-description-title {
            font-size: 16px;
            font-weight: bold;
            color: #444;
            text-align: center;
        }

        .stats {
            display: flex;
            gap: 28px;
            margin-top: 15px;
            flex-shrink: 0;
        }

        .stat-box {
            text-align: center;
        }

        .stat-title {
            font-size: 15px;
            color: black;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: black;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .tweet-card {
            background: white;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 20px;
        }

        .tweet-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tweet-info {
            font-size: 13px;
            color: #555;
            margin-bottom: 12px;
        }

        .tweet-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 14px;
            color: black;
        }

        .tweet-content {
            font-size: 15px;
            color: black;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .tweet-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            color: black;
            font-size: 15px;
        }

        .reaction-btn {
            background: #fff;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
            font-size: 14px;
        }

        .reaction-btn:hover {
            transform: scale(1.05);
        }

        .like-btn {
            color: #3490dc;
        }

        .like-btn:hover {
            background: #e8f5ff;
            border-color: #3490dc;
        }

        .dislike-btn {
            color: #e74c3c;
        }

        .dislike-btn:hover {
            background: #ffe5e5;
            border-color: #ff6b6b;
        }

        .repost-btn {
            color: #6c5ce7;
        }

        .repost-btn:hover {
            background: #f0e6ff;
            border-color: #9b59b6;
        }

        .comment-btn {
            color: #2dce89;
        }

        .comment-btn:hover {
            background: #e8f8f1;
            border-color: #2dce89;
        }

        .bookmark-btn {
            color: #ff9f43;
        }

        .bookmark-btn:hover {
            background: #fff4e0;
            border-color: #ff9f43;
        }

        .tweet-menu-container {
            position: relative;
        }

        .tweet-menu-btn {
            border: none;
            background: transparent;
            font-size: 18px;
            cursor: pointer;
        }

        .tweet-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            z-index: 10;
        }

        .tweet-dropdown button {
            width: 100%;
            border: none;
            background: white;
            padding: 12px;
            text-align: left;
            cursor: pointer;
        }

        .tweet-dropdown button:hover {
            background: #f5f5f5;
        }

        .tweet-menu-container:hover .tweet-dropdown {
            display: block;
        }

        .edit-modal {
            display: none;
            margin-top: 20px;
            background: #fafafa;
            padding: 20px;
            border-radius: 15px;
        }

        .edit-modal input,
        .edit-modal textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        .description-modal {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .description-modal textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            resize: none;
            box-sizing: border-box;
        }

        .description-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .save-btn {
            background: #b7e4c7;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .cancel-btn {
            background: #f5c2c7;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
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
            background: #3b8edb;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
        }

        #scrollTopBtn:hover {
            background: #2f7cc2;
            transform: translateY(-3px);
        }

        .private-lock-box {
            background: white;
            border-radius: 18px;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
        }

        .follow-btn {
            border: none;
            padding: 10px 22px;
            border-radius: 20px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.2s;
        }

        .follow-btn:hover {
            transform: scale(1.05);
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

        .nav-icon-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            text-decoration: none;
            position: relative;
        }

        .like-btn.active {
            background: #dbeeff;
            border-color: #3490dc;
        }

        .dislike-btn.active {
            background: #ffe5e5;
            border-color: #e74c3c;
        }

        .repost-btn.active {
            background: #ede9fd;
            border-color: #6c5ce7;
        }

        .bookmark-btn.active {
            background: #dbeeff;
            border-color: #3490dc;
        }

        .private-lock-icon {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 10px;
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
        <h1 class="section-title">Profile</h1>
        <div class="profile-card">

            <div class="profile-left">
                <div class="profile-user-info">
                    <div class="profile-avatar">
                        <img src="{{ asset('image/profile.png') }}" class="icon-img" alt="Avatar">
                    </div>

                    <div class="profile-details">
                        <div class="username-row">
                            <h1 style="margin:0;">
                                {{ $user->username }}
                            </h1>

                            @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('follow', $user->id) }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="follow-btn-small" style="background: {{ $isFollowing ? '#95a5a6' : '#3490dc' }};">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                </form>

                                <div class="tweet-menu-container" style="display: inline-block; margin-left: 4px;">
                                    <button class="tweet-menu-btn">•️•️•️</button>
                                    <div class="tweet-dropdown" style="left: 0; right: auto; margin-top: 6px;">

                                        <form action="{{ route('block', $user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin memproses akun ini?')">
                                            @csrf
                                            <button type="submit" style="color: #333;">
                                                Block
                                            </button>
                                        </form>

                                        <form action="{{ route('mute', $user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin memproses status bisu akun ini?')">
                                            @csrf
                                            <button type="submit" style="color: #e67e22;">
                                                Mute
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="description-section">
                            <p class="description-text">
                                {{ $user->description ?: 'No description yet.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <a href="{{ route('profile.following', $user->username) }}" style="text-decoration:none;color:black;">
                        <div class="stat-title">Following</div>
                        <div class="stat-number">{{ $user->following->count() }}</div>
                    </a>
                </div>

                <div class="stat-box">
                    <a href="{{ route('profile.followers', $user->username) }}" style="text-decoration:none;color:black;">
                        <div class="stat-title">Followers</div>
                        <div class="stat-number">{{ $user->followers->count() }}</div>
                    </a>
                </div>

                <div class="stat-box">
                    <div class="stat-title">Likes</div>
                    <div class="stat-number">
                        {{ $tweets->sum(function ($tweet) { return $tweet->likes->count(); }) }}
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-title">Dislikes</div>
                    <div class="stat-number">
                        {{ $tweets->sum(function ($tweet) { return $tweet->dislikes->count(); }) }}
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-title">Tweets</div>
                    <div class="stat-number">{{ $tweets->count() }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-title">Repost</div>
                    <div class="stat-number">
                        {{ $tweets->sum(function ($tweet) { return $tweet->reposts->count(); }) }}
                    </div>
                </div>
            </div>

        </div>

        @if(auth()->id() === $user->id)
            <button type="button" class="edit-description-card" onclick="openDescriptionEdit()">
                <span class="edit-description-title">Edit Profile</span>
            </button>

            <div class="description-modal" id="descriptionModal">
                <form action="/profile/update-description" method="POST">
                    @csrf
                    <textarea name="description" rows="4" placeholder="Write your description...">{{ $user->description }}</textarea>
                    <div class="description-actions">
                        <button type="submit" class="save-btn">Save</button>
                        <button type="button" class="cancel-btn" onclick="closeDescriptionEdit()">Cancel</button>
                    </div>
                </form>
            </div>
        @endif

        @if($isLocked)
            <div class="private-lock-box">
                    <img
                        src="{{ asset('image/lock.png') }}"
                        class="private-lock-icon"
                        alt="Private">
                <h3 style="margin: 0 0 10px 0; color: #333;">This Profile is Private</h3>
                <p style="margin: 0; color: #777; font-size: 15px;">Follow this account to see posts</p>
            </div>
        @else
            <h1 class="section-title">Your Tweets</h1>

            @foreach ($tweets as $tweet)
                @php
                    $userLiked     = $tweet->likes->contains('user_id', auth()->id());
                    $userDisliked  = $tweet->dislikes->contains('user_id', auth()->id());
                    $userReposted  = $tweet->reposts->contains('user_id', auth()->id());

                    $userSaved = \App\Models\Bookmark::where('user_id', auth()->id())
                        ->where('tweet_id', $tweet->id)
                        ->exists();
                @endphp
                <div class="tweet-card">
                    <div class="tweet-top">
                        <div class="tweet-info">
                            {{ $user->username }} • posted {{ $tweet->created_at->diffForHumans() }}
                        </div>

                        @if(auth()->id() == $user->id)
                            <div class="tweet-menu-container">
                                <button class="tweet-menu-btn">•••</button>
                                <div class="tweet-dropdown">
                                    <button onclick="openEdit({{ $tweet->id }})">Edit</button>
                                    <form action="/tweets/{{ $tweet->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color:red;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="tweet-title">
                        {{ $tweet->title }}
                    </div>

                    <div class="tweet-content">
                        {!! preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="/user/$1" class="mention-link">@$1</a>', e($tweet->content)) !!}
                    </div>

                    <div class="tweet-actions">
                        <button type="button" class="like-btn reaction-btn{{ $userLiked ? 'active' : '' }}" data-id="{{ $tweet->id }}">
                            <img
                                src="{{ asset('image/' . ($userLiked ? 'liked.png' : 'like.png')) }}"
                                class="icon-img"
                                alt="Like">
                            <span id="like-count-{{ $tweet->id }}">{{ $tweet->likes ? $tweet->likes->count() : 0 }}</span>
                        </button>

                        <button type="button" class="dislike-btn reaction-btn {{ $userDisliked ? 'active' : '' }}" data-id="{{ $tweet->id }}">
                            <img
                                src="{{ asset('image/' . ($userDisliked ? 'liked.png' : 'like.png')) }}"
                                class="icon-img"
                                alt="Dislike"
                                style="transform: scaleY(-1);">
                            <span id="dislike-count-{{ $tweet->id }}">{{ $tweet->dislikes->count() }}</span>
                        </button>

                        <button type="button" class="repost-btn reaction-btn {{ $userReposted ? 'active' : '' }}" data-id="{{ $tweet->id }}">
                            <img
                                src="{{ asset('image/repost.png') }}"
                                class="icon-img"
                                alt="Repost">
                            <span id="repost-count-{{ $tweet->id }}">{{ $tweet->reposts->count() }}</span>
                        </button>

                        <a href="{{ route('tweets.show', $tweet->id) }}" class="reaction-btn comment-btn"
                            style="text-decoration:none;">
                            💬 {{ $tweet->comments->count() }}
                        </a>

                        <form action="{{ route('bookmarks.store') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                            <button type="submit" class="reaction-btn bookmark-btn {{ $userSaved ? 'active' : '' }}">
                                <img
                                    src="{{ asset($userSaved ? 'image/saved.png' : 'image/save.png') }}"
                                    class="icon-img"
                                    alt="Bookmark">
                                {{ $userSaved ? 'Saved' : 'Save' }}
                            </button>
                        </form>
                    </div>

                    <div class="edit-modal" id="edit-{{ $tweet->id }}">
                        <form action="/tweets/{{ $tweet->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $tweet->title }}">
                            <textarea name="content" rows="4">{{ $tweet->content }}</textarea>
                            <div class="description-actions">
                                <button type="submit" class="save-btn">Save</button>
                                <button type="button" class="cancel-btn" onclick="closeEdit({{ $tweet->id }})">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    <button id="scrollTopBtn" onclick="scrollToTop()">↑</button>

    <script>
        function openDescriptionEdit() {
            document.getElementById('descriptionModal').style.display = 'block';
        }

        function closeDescriptionEdit() {
            document.getElementById('descriptionModal').style.display = 'none';
        }

        function openEdit(id) {
            document.getElementById(`edit-${id}`).style.display = 'block';
        }

        function closeEdit(id) {
            document.getElementById(`edit-${id}`).style.display = 'none';
        }

        window.onscroll = function () {
            const button = document.getElementById("scrollTopBtn");
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
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
    </script>
</body>
</html>