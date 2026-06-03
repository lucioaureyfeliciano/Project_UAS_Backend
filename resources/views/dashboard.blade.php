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
            width: 600px;
            margin: 20px auto;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
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
            margin-bottom: 18px;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: white;
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
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
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
            box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
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
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            transition: 0.3s;
            z-index: 99;
        }

        #scrollTopBtn:hover {
            background: #2f7cc2;
            transform: translateY(-3px);
        }

        .mute-btn:hover {
            background: #d35400;
        }

        .notification-btn {
            position: relative;
        }

        .notif-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .comment-btn {
            color: #27ae60;
        }

        .comment-btn:hover {
            background: #eafaf1;
            border-color: #27ae60;
        }
    </style>
</head>
<body>

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
    </div>
</div>

<div class="container">

    @if(session('success'))
        <div class="card" id="successAlert" style="border: 1px solid #2ecc71; background: #ecf9f1; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="card" style="border: 1px solid #e74c3c; background: #fdf2f2; color: #721c24;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <h3>Welcome, {{ auth()->user()->username }}</h3>
        <p>This is your dashboard</p>
    </div>

    <div class="card">
        <h3>Post a Tweet</h3>
        <form method="POST" action="/tweets">
            @csrf
            <div style="margin-bottom: 12px;">
                <label for="title">Title</label><br>
                <input id="title" name="title" type="text" value="{{ old('title') }}" style="width:100%; padding:8px; margin-top:4px; box-sizing: border-box;" />
                @error('title')
                    <div style="color:red; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 12px;">
                <label for="content">Content</label><br>
                <textarea id="content" name="content" rows="4" style="width:100%; padding:8px; margin-top:4px; box-sizing: border-box;">{{ old('content') }}</textarea>
                @error('content')
                    <div style="color:red; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="logout-btn" style="background:#3490dc;">Add Tweet</button>
        </form>
    </div>

    <div class="card">
        <h2>Your Tweets</h2>
        @if($tweets->isEmpty())
            <p>No tweets yet. Tambahkan tweet pertama kamu!</p>
        @else
            @foreach($tweets as $tweet)
                <div class="tweet-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div class="tweet-content">
                            <h4>{{ $tweet->title }}</h4>
                            <p>{{ $tweet->content }}</p>
                            <small>{{ $tweet->user?->username ?? 'Unknown' }} • {{ $tweet->created_at->diffForHumans() }}</small>
                        </div>

                        <div style="display: flex; gap: 8px; align-items: center;">
                            {{-- Dropdown Tweet Sendiri --}}
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

                                <div class="tweet-menu-container">
                                    <button class="tweet-menu-btn">•••</button>
                                    <div class="tweet-dropdown">
                                        @if(!$isBlocked)
                                            <form method="POST" action="{{ route('block', $tweet->user_id) }}" onsubmit="return confirm('Yakin ingin memblokir akun ini?')">
                                                @csrf
                                                <button type="submit" style="color: #7f8c8d;">Block</button>
                                            </form>
                                        @endif

                                        @if(!$isBlocked && !$isMuted)
                                            <form method="POST" action="{{ route('mute', $tweet->user_id) }}" onsubmit="return confirm('Yakin ingin membisukan akun ini?')">
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
                                    <button type="button" class="cancel-btn" onclick="closeEdit({{ $tweet->id }})">Cancel</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="tweet-actions">
                        <button class="like-btn reaction-btn" data-id="{{ $tweet->id }}">
                            👍 <span id="like-count-{{ $tweet->id }}">{{ $tweet->likes ? $tweet->likes->count() : 0 }}</span>
                        </button>
                        <button class="dislike-btn reaction-btn" data-id="{{ $tweet->id }}">
                            👎 <span id="dislike-count-{{ $tweet->id }}">{{ $tweet->dislikes->count() }}</span>
                        </button>
                        <button class="repost-btn reaction-btn" data-id="{{ $tweet->id }}">
                            🔁 <span id="repost-count-{{ $tweet->id }}">{{ $tweet->reposts->count() }}</span>
                        </button>

                        <a href="{{ route('tweets.show', $tweet->id) }}" class="reaction-btn comment-btn" style="text-decoration:none;">
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

setTimeout(() => {
    const alertBox = document.getElementById('successAlert');
    if (alertBox) {
        alertBox.style.transition = '0.5s';
        alertBox.style.opacity = '0';
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 500);
    }
}, 5000);

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

</script>
</script>

</body>
</html>