@php
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            width: 600px;
            margin: 20px auto;
        }

        .card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .message-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            transition: 0.2s;
        }

        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .username {
            font-weight: bold;
            color: #3490dc;
        }

        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .unread-badge {
            background: #e3342f;
            color: white;
            min-width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
        }

        .has-unread {
            border-left: 5px solid #3490dc;
        }

        .preview {
            color: #555;
            margin-top: 5px;
        }

        .chat-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .chat-btn:hover {
            background: #2779bd;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .search-input {
            width: 75%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-btn {
            padding: 10px 15px;
            background: #3490dc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #2779bd;
        }

        .result-user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h2 {
            margin-top: 0;
        }

    </style>
</head>
<body>
@include('components.toast')

<div class="navbar">

    <a href="/dashboard" class="back-btn">
        ← Back
    </a>

    <div>💬 Inbox</div>

</div>

<div class="container">

    {{-- Search User --}}
    <div class="card">

        <h2>Search User</h2>

        <form action="/messages/search" method="GET">

            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Search username..."
                value="{{ $keyword ?? '' }}"
            >

            <button type="submit" class="search-btn">
                Search
            </button>

        </form>

    </div>

    {{-- Search Results --}}
    @if(isset($users))

        <div class="card">

            <h2>Search Results</h2>

            @forelse($users as $user)

                <div class="result-user">

                    <strong>
                        {{ $user->username }}
                    </strong>

                    <a
                        href="/messages/chat/{{ $user->id }}"
                        class="chat-btn"
                    >
                        Start Chat
                    </a>

                </div>

            @empty

                <p>No users found.</p>

            @endforelse

        </div>

    @endif

    {{-- Conversation List --}}
    <div class="card">
        <h2>Your Conversations</h2>
    </div>

    @forelse($conversations as $conversation)

        @php
            $otherUser = $conversation->sender_id == auth()->id()
                ? $conversation->receiver
                : $conversation->sender;
        @endphp

        <div class="message-card {{ ($unreadCounts[$otherUser->id] ?? 0) > 0 ? 'has-unread' : '' }}">

            <div class="user-header">

                <div class="username">
                    {{ $otherUser->username }}
                </div>

                @if(($unreadCounts[$otherUser->id] ?? 0) > 0)

                    <div class="unread-badge">
                        {{ $unreadCounts[$otherUser->id] }}
                    </div>

                @endif

            </div>

            <div class="preview">
                {{ Str::limit($conversation->message, 80) }}
            </div>

            <a
                href="/messages/chat/{{ $otherUser->id }}"
                class="chat-btn"
            >
                Open Chat
            </a>

        </div>

    @empty

        <div class="card">
            No conversations yet.
        </div>

    @endforelse

</div>

</body>
</html>
