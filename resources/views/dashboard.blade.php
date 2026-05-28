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

        .like-btn span,
        .dislike-btn span,
        .repost-btn span {
            font-weight: bold;
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

        .edit-btn {
            background: #f39c12;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="navbar">

    <div>Social Media</div>

    <div class="menu-container">

        <button class="menu-button">
            ☰
        </button>

        <div class="menu-dropdown">

            <a href="/profile">
                Profile
            </a>

            <a href="/community">
                Community
            </a>

            <a href="/usage">
                Usage Statistics
            </a>

            <form method="POST" action="/logout">
                @csrf

                <button type="submit">
                    Logout
                </button>
            </form>

        </div>

    </div>

</div>

<div class="container">

    @if(session('success'))
        <div class="card" id="successAlert" style="border: 1px solid #2ecc71; background: #ecf9f1; color: #155724;">
            {{ session('success') }}
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
                <input id="title" name="title" type="text" value="{{ old('title') }}" style="width:100%; padding:8px; margin-top:4px;" />
                @error('title')
                    <div style="color:red; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 12px;">
                <label for="content">Content</label><br>
                <textarea id="content" name="content" rows="4" style="width:100%; padding:8px; margin-top:4px;">{{ old('content') }}</textarea>
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
                <div style="margin-bottom:15px; padding:12px; border:1px solid #ddd; border-radius:8px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h4 style="margin:0 0 6px 0;">{{ $tweet->title }}</h4>
                            <p style="margin:0 0 8px 0;">{{ $tweet->content }}</p>
                            <small>By {{ $tweet->user?->username ?? 'unknown' }} | {{ $tweet->created_at->diffForHumans() }}</small>
                        </div>
                    
                        {{-- Tombol delete --}}
                        @if($tweet->user_id === auth()->id())
                            <div style="display: flex; gap: 5px;">
                                <form method="POST" action="/tweets/{{ $tweet->id }}" onsubmit="return confirm('Yakin ingin menghapus tweet ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    {{-- Menu edit --}}
                    @if($tweet->user_id === auth()->id())
                        <details style="margin-top: 10px; font-size: 13px;">
                            <summary style="cursor:pointer; color: #3490dc; font-weight: bold;">Edit Tweet</summary>
                            <form method="POST" action="/tweets/{{ $tweet->id }}" style="margin-top: 8px; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                                @csrf
                                @method('PUT')
                                <div style="margin-bottom: 6px;">
                                    <label style="font-weight: bold;">Title:</label>
                                    <input type="text" name="title" value="{{ $tweet->title }}" style="width:100%; padding:6px; margin-top:4px;" required>
                                </div>
                                <div style="margin-bottom: 6px;">
                                    <label style="font-weight: bold;">Content:</label>
                                    <textarea name="content" style="width:100%; padding:6px; margin-top:4px;" rows="2" required>{{ $tweet->content }}</textarea>
                                </div>
                                <button type="submit" class="edit-btn">Save Changes</button>
                            </form>
                        </details>
                    @endif
                </div>
                <div class="tweet-card">
                    <div class="tweet-content">
                        <h4>{{ $tweet->title }}</h4>
                        <p>{{ $tweet->content }}</p>
                        <small>By {{ $tweet->user?->username ?? 'Unknown' }} · {{ $tweet->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="tweet-actions">
                        <button class="dislike-btn reaction-btn" data-id="{{ $tweet->id }}">
                            👎 <span id="dislike-count-{{ $tweet->id }}">
                                {{ $tweet->dislikes->count() }}
                            </span>
                        </button>
                        <button class="like-btn reaction-btn" data-id="{{ $tweet->id }}">
                            👍 <span id="like-count-{{ $tweet->id }}">
                                {{ $tweet->likes ? $tweet->likes->count() : 0 }}
                            </span>
                        </button>
                        <button class="repost-btn reaction-btn" data-id="{{ $tweet->id }}">
                            🔁 <span id="repost-count-{{ $tweet->id }}">
                                {{ $tweet->reposts->count() }}
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif



    </div>

</div>

<script>

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

</script>

</body>
</html>

{{-- JavaScript agar saat dislike dipencet tidak reload page dan langsung update jumlah dislike-nya --}}
<script>
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
</script>

{{-- JavaScript agar saat like dipencet tidak reload page dan langsung update jumlah like-nya --}}
<script>
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
</script>

{{-- JavaScript agar saat repost dipencet tidak reload page dan langsung update jumlah like-nya --}}
<script>
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

            document.getElementById(
                `repost-count-${tweetId}`
            ).innerText = data.count;

        });

    });

});

</script>