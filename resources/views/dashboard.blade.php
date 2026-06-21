<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

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
        }

        .container {
            width: 75%;
            max-width: 900px;
            margin: 35px auto;
        }

        .card {
            background: white;
            padding: 22px; 
            margin-bottom: 20px; 
            border-radius: 18px; 
            border: 1px solid #ddd; 
            width: 100%;
            box-sizing: border-box;
        }

        .logout-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .reaction-btn {
            background: #fff;
            border: 1px solid #ddd;
            padding: 6px 12px;
            border-radius: 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
            margin-right: 8px;
        }

        .reaction-btn:hover {
            transform: scale(1.05);
        }

        .dislike-btn {
            color: #e74c3c;
        }

        .dislike-btn:hover {
            background: #ffe5e5;
            border-color: #ff6b6b;
        }

        .like-btn {
            color: #3490dc;
        }

        .like-btn:hover {
            background: #e8f5ff;
            border-color: #3490dc;
        }

        .repost-btn {
            color: #6c5ce7;
        }

        .repost-btn:hover {
            background: #f0e6ff;
            border-color: #9b59b6;
        }

        .tweet-card {
            margin-bottom: 20px;
            padding: 22px; 
            border: 1px solid #ddd;
            border-radius: 18px; 
            background: white;
            width: 100%;
            box-sizing: border-box;
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
            border: 1px solid #ddd;
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

        .tweet-card h4 {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
        }

        .tweet-card p {
            margin: 0 0 10px 0;
            line-height: 1.5;
        }

        .tweet-card small {
            color: #666;
        }

        .tweet-actions {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .menu-container {
            position: relative;
            display: inline-block;
        }

        .menu-button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 20px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .menu-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 150px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 10;
        }

        .menu-dropdown a,
        .menu-dropdown button {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            background: white;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        .menu-dropdown a:hover,
        .menu-dropdown button:hover {
            background: #f2f2f2;
        }

        .menu-container:hover .menu-dropdown {
            display: block;
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
            z-index: 99;
        }

        #scrollTopBtn:hover {
            background: #b4cde5;
            transform: translateY(-3px);
        }

        .comment-btn {
            color: #27ae60;
        }

        .comment-btn:hover {
            background: #eafaf1;
            border-color: #27ae60;
        }

        .author-link {
            color: #3490dc;
            text-decoration: none;
            font-weight: bold;
        }

        .author-link:hover {
            text-decoration: underline;
        }

        .mention-autocomplete-wrapper {
            position: relative;
        }

        .mention-autocomplete-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            max-height: 200px;
            overflow-y: auto;
            z-index: 50;
            padding: 6px 0;
        }

        .mention-autocomplete-dropdown.show {
            display: block;
        }

        .mention-suggestion {
            padding: 10px 12px;
            cursor: pointer;
            color: #333;
        }

        .mention-suggestion:hover {
            background: #3490dc;
            color: white;
        }

        .mention-link {
            color: #3490dc;
            font-weight: bold;
            text-decoration: none;
        }

        .mention-link:hover {
            text-decoration: underline;
        }

        .card form input[type="text"],
        .card form textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;   
            border-radius: 8px;           
            font-size: 14px;
            font-family: Arial, sans-serif;
            outline: none;             
        }

        .share-modal {
            display: none;
            margin-top: 12px;
            padding: 14px;
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
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
    </style>
</head>

<body>
    @include('components.toast')

    @php
        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    @endphp

    <div class="navbar">
        <div>Social Media</div>
        <div style="display:flex; gap:10px; align-items:center;">
            {{-- Notifications --}}
            <a class="menu-button notification-btn" href="{{ route('notifications.index') }}"> 🔔
                @if($unreadCount > 0)
                    <span class="notif-badge">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            {{-- Bookmarks --}}
            <a class="menu-button" href="{{ route('bookmarks.index') }}">🔖</a>
            <a class="menu-button" href="/messages/inbox">💬</a>
            <div class="menu-container">
                <button class="menu-button">☰</button>
                <div class="menu-dropdown">
                    <a href="/profile">Profile</a>
                    <a href="/community">Community</a>
                    <a href="/usage">Usage Statistics</a>
                    <a href="/privacy">Privacy Settings</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            {{-- Search --}}
            <form action="{{ route('search.users') }}" method="GET">

                <input type="text" name="search" placeholder="What to look? " style="
                padding:8px;
                border:none;
                border-radius:8px;
            ">
            </form>
        </div>
    </div>

    <div class="container">

        <div class="card">
            <h3>Welcome, {{ auth()->user()->username }}</h3>
            <p>This is your dashboard</p>
        </div>

        <div class="card">
            <h3>Trending Hashtags</h3>
            @forelse($hashtags as $hashtag)
                <div style="padding:8px 0; border-bottom:1px solid #eee;">
                    <strong>
                        <a href="/hashtags/{{ $hashtag->name }}">
                            #{{ $hashtag->name }}
                        </a>
                    </strong>
                    <span style="float:right;">
                        {{ $hashtag->tweets_count }}
                    </span>
                </div>
            @empty
                <p>No hashtags yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h3>Post a Tweet</h3>
            <form method="POST" action="/tweets">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label for="title">Title</label><br>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="Write your title..." />
                    @error('title')
                        <div style="color:red; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 12px;">
                    <label for="content">Content</label><br>
                    <div class="mention-autocomplete-wrapper">
                        <textarea id="content" class="mention-autocomplete-input" name="content" rows="4"
                            style="width:100%; padding:8px; margin-top:4px; box-sizing: border-box;">{{ old('content') }}</textarea>
                        <div class="mention-autocomplete-dropdown"></div>
                    </div>
                    @error('content')
                        <div style="color:red; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="logout-btn" style="background:#3490dc; border-radius: 8px; padding: 10px 22px;">Add Tweet</button>
            </form>
        </div>

        <div class="card" style="background: transparent; border: none; padding: 0;">
            <h2>Your Tweets</h2>
            @if($tweets->isEmpty())
                <p>No tweets yet. Tambahkan tweet pertama kamu!</p>
            @else
                @foreach($tweets as $tweet)
                        <div class="tweet-card">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div class="tweet-content">
                                    <h4>{{ $tweet->title }}</h4>
                                    {!! preg_replace(
                                        '/@([a-zA-Z0-9_]+)/',
                                        '<a href="/user/$1" class="mention-link">@$1</a>',
                                        e($tweet->content)
                                    ) !!}

                                    <br><br>
                                    <small>
                                        @if($tweet->user_id === auth()->id())
                                            <a href="/profile" style="text-decoration: none; color: #3490dc; font-weight: bold;">
                                                {{ $tweet->user?->username ?? 'Unknown' }}
                                            </a>
                                        @else
                                            <a href="{{ route('profile.show', $tweet->user?->username) }}"
                                                style="text-decoration: none; color: #3490dc; font-weight: bold;">
                                                {{ $tweet->user?->username ?? 'Unknown' }}
                                            </a>
                                        @endif
                                        •
                                        {{ $tweet->created_at->diffForHumans() }}
                                        @if($tweet->updated_at != $tweet->created_at)
                                            <span style="color: #999; font-size: 0.85rem; font-style: italic;">
                                                (Edited {{ $tweet->updated_at->diffForHumans() }})
                                            </span>
                                        @endif
                                    </small>
                                </div>

                                <div style="display: flex; gap: 8px; align-items: center;">
                                    @if($tweet->user_id === auth()->id())
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

                                    @if($tweet->user_id !== auth()->id())
                                        @php
                                            $isBlocked = \App\Models\Block::where('user_id', auth()->id())
                                                ->where('blocked_user_id', $tweet->user_id)
                                                ->exists();

                                            $isMuted = \App\Models\Mute::where('user_id', auth()->id())
                                                ->where('muted_user_id', $tweet->user_id)
                                                ->exists();
                                        @endphp

                                        @php
                                            $isFollowing = \App\Models\Follow::where(
                                                'follower_id',
                                                auth()->id()
                                            )
                                                ->where(
                                                    'following_id',
                                                    $tweet->user_id
                                                )
                                                ->exists();
                                        @endphp

                                        <form method="POST" action="{{ route('follow', $tweet->user_id) }}">
                                            @csrf
                                            <button type="submit" class="reaction-btn" style="
                                                                                                    color:white;
                                                                                                    background:
                                                                                                        {{ $isFollowing ? '#95a5a6' : '#3490dc' }};
                                                                                                ">
                                                {{ $isFollowing ? 'Following' : 'Follow' }}
                                            </button>
                                        </form>

                                        <div class="tweet-menu-container">
                                            <button class="tweet-menu-btn">•••</button>
                                            <div class="tweet-dropdown">
                                                @if(!$isBlocked)
                                                    <form method="POST" action="{{ route('block', $tweet->user_id) }}"
                                                        onsubmit="return confirm('Yakin ingin memblokir akun ini?')">
                                                        @csrf
                                                        <button type="submit" style="color: #7f8c8d;">Block</button>
                                                    </form>
                                                @endif

                                                @if(!$isBlocked && !$isMuted)
                                                    <form method="POST" action="{{ route('mute', $tweet->user_id) }}"
                                                        onsubmit="return confirm('Yakin ingin membisukan akun ini?')">
                                                        @csrf
                                                        <button type="submit" style="color: #d35400;">Mute</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($tweet->user_id === auth()->id())
                                <div class="edit-modal" id="edit-{{ $tweet->id }}">
                                    <form action="/tweets/{{ $tweet->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="title" value="{{ $tweet->title }}">
                                        <textarea name="content" rows="4">{{ $tweet->content }}</textarea>
                                        <div class="description-actions">
                                            <button type="submit" class="save-btn">Save</button>
                                            <button type="button" class="cancel-btn"
                                                onclick="closeEdit({{ $tweet->id }})">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="tweet-actions">
                                <button class="like-btn reaction-btn" data-id="{{ $tweet->id }}">
                                    👍 <span
                                        id="like-count-{{ $tweet->id }}">{{ $tweet->likes ? $tweet->likes->count() : 0 }}</span>
                                </button>
                                <button class="dislike-btn reaction-btn" data-id="{{ $tweet->id }}">
                                    👎 <span id="dislike-count-{{ $tweet->id }}">{{ $tweet->dislikes->count() }}</span>
                                </button>
                                <button class="repost-btn reaction-btn" data-id="{{ $tweet->id }}">
                                    🔁 <span id="repost-count-{{ $tweet->id }}">{{ $tweet->reposts->count() }}</span>
                                </button>

                                <a href="{{ route('tweets.show', $tweet->id) }}" class="reaction-btn comment-btn"
                                    style="text-decoration:none;">
                                    💬 {{ $tweet->comments->count() }}
                                </a>

                                <form action="{{ route('bookmarks.store') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                    <button type="submit" class="reaction-btn"
                                        style="color:#3490dc; background:white; font-size:14px;">
                                        🔖 Bookmark
                                    </button>
                                </form>

                               <button class="reaction-btn" style="color:#6c5ce7;"
                                    onclick="toggleShareModal('share-tw-{{ $tweet->id }}')">
                                    💬 Share
                                </button>

                                <div id="share-tw-{{ $tweet->id }}" class="share-modal">

                                    <div class="share-header">
                                        💬 Share to Message
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

                                        <textarea
                                            name="message"
                                            class="share-textarea"
                                            placeholder="Add a message..."
                                        >[TWEET:{{ $tweet->id }}]</textarea>

                                        <div class="share-actions">
                                            <button
                                                type="button"
                                                class="share-cancel-btn"
                                                onclick="toggleShareModal('share-tw-{{ $tweet->id }}')">
                                                Cancel
                                            </button>

                                            <button type="submit" class="share-send-btn">
                                                Send
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div> 
                        </div>
                @endforeach
            @endif
        </div>

    </div>

    <button id="scrollTopBtn" onclick="scrollToTop()">↑</button>

    <script>
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
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function setupMentionAutocomplete(textarea) {
            const wrapper = textarea.closest('.mention-autocomplete-wrapper');
            const dropdown = wrapper.querySelector('.mention-autocomplete-dropdown');
            let debounceTimer = null;
            let activeMention = null;
            let requestId = 0;
            let ignoreNextInput = false;

            const hideDropdown = () => {
                dropdown.classList.remove('show');
                dropdown.innerHTML = '';
                activeMention = null;
            };

            const findActiveMention = () => {
                const cursorPosition = textarea.selectionStart;
                const textBeforeCursor = textarea.value.slice(0, cursorPosition);
                const match = textBeforeCursor.match(/(^|[\s(])@([A-Za-z0-9_]{1,30})$/);

                if (!match) {
                    return null;
                }

                return {
                    keyword: match[2],
                    start: cursorPosition - match[2].length - 1,
                    end: cursorPosition
                };
            };

            const insertMention = (username) => {
                if (!activeMention) {
                    return;
                }

                textarea.value =
                    textarea.value.slice(0, activeMention.start) +
                    `@${username}` +
                    textarea.value.slice(activeMention.end);

                const cursorPosition = activeMention.start + username.length + 1;
                textarea.focus();
                textarea.setSelectionRange(cursorPosition, cursorPosition);
                ignoreNextInput = true;
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                hideDropdown();
            };

            const renderSuggestions = (users) => {
                if (!users.length) {
                    hideDropdown();
                    return;
                }

                dropdown.innerHTML = '';

                users.forEach((user) => {
                    const item = document.createElement('div');
                    item.className = 'mention-suggestion';
                    item.textContent = user.username;
                    item.addEventListener('mousedown', (event) => {
                        event.preventDefault();
                        insertMention(user.username);
                    });
                    dropdown.appendChild(item);
                });

                dropdown.classList.add('show');
            };

            textarea.addEventListener('input', () => {
                if (ignoreNextInput) {
                    ignoreNextInput = false;
                    hideDropdown();
                    return;
                }

                clearTimeout(debounceTimer);

                const mention = findActiveMention();
                if (!mention) {
                    hideDropdown();
                    return;
                }

                activeMention = mention;

                debounceTimer = setTimeout(() => {
                    const currentRequest = ++requestId;

                    fetch(`/mentions/search?q=${encodeURIComponent(mention.keyword)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(users => {
                            if (currentRequest === requestId) {
                                renderSuggestions(users);
                            }
                        })
                        .catch(() => hideDropdown());
                }, 250);
            });

            textarea.addEventListener('keydown', () => {
                setTimeout(() => {
                    if (!findActiveMention()) {
                        hideDropdown();
                    }
                }, 0);
            });

            document.addEventListener('click', (event) => {
                if (!wrapper.contains(event.target)) {
                    hideDropdown();
                }
            });
        }

        document.querySelectorAll('.mention-autocomplete-input').forEach(setupMentionAutocomplete);

        // AJAX Dislike
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

        // AJAX Like
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

        // AJAX Repost
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

        window.onscroll = function () {
            const button = document.getElementById("scrollTopBtn");
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
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

        function toggleShareModal(id) {
            const el = document.getElementById(id);

            if (!el) return;

            el.style.display =
                el.style.display === 'block'
                    ? 'none'
                    : 'block';
        }
    </script>
</body>

</html>
