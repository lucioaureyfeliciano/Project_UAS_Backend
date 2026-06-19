<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>

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

        .notif-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .notif-card.unread {
            background: #f0f8ff;
            border-left: 4px solid #3490dc;
        }

        .notif-card.read {
            opacity: 0.8;
            border-left: 4px solid #ccc;
        }

        .notif-body {
            flex: 1;
        }

        .notif-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .badge-like {
            background: #cce5ff;
            color: #004085;
        }

        .badge-comment {
            background: #d4edda;
            color: #155724;
        }

        .badge-repost {
            background: #e2d9f3;
            color: #432874;
        }

        .badge-follow {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-mention {
            background: #ffeaa7;
            color: #6c5ce7;
        }

        .notif-message {
            color: #333;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .notif-time {
            font-size: 12px;
            color: #999;
        }

        .notif-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-info h2 {
            margin: 0;
        }

        .notification-total {
            color: #888;
        }
  
        .btn-read {
            background: #d4edda;
            color: #155724;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-read:hover {
            background: #c3e6cb;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .mark-all-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .mark-all-btn:hover {
            background: #2779bd;
        }

        .empty-state {
            color: #888;
            text-align: center;
        }

        .notif-links {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .notif-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: 0.2s;
        }

        .tweet-link {
            background: #d5e5f4;
            color: #3490dc;
        }

        .tweet-link:hover {
            background: #96B3D2;
        }

        .user-link {
            background: #f0e6ff;
            color: #6c5ce7;
        }

        .user-link:hover {
            background: #e4d5ff;
        }

        svg {
            width: 12px;
            height: 12px;
        }

        nav {
            margin-top: 20px;
            text-align: center;
        }

        nav p {
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        nav a,
        nav span {
            display: inline-block;
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            background: white;
            margin: 0 2px;
        }

        nav a:hover {
            background: #f0f0f0;
        }

        nav span[aria-current="page"] span {
            background: #3490dc;
            color: white;
            border-color: #3490dc;
        }

        .notification-filters {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        .notification-type-filters {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .type-filter-tab {
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            background: white;
            color: #555;
            border: 1px solid #ddd;
            transition: 0.2s;
        }

        .type-filter-tab:hover {
            background: #f5f5f5;
        }

        .type-filter-tab.active {
            background: #6c5ce7;
            color: white;
            border-color: #6c5ce7;
        }

        .filter-tab {
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            background: white;
            color: #555;
            border: 1px solid #ddd;
            transition: 0.2s;
        }

        .filter-tab:hover {
            background: #f5f5f5;
        }

        .filter-tab.active {
            background: #3490dc;
            color: white;
            border-color: #3490dc;
        }

        .delete-all-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .delete-all-btn:hover {
            background: #c0392b;
        }

        h2 {
            margin-top: 0;
        }
    </style>   
</head>
<body>
@include('components.toast')

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div>🔔 Notifications</div>
    <div></div>
</div>

<div class="container">

    {{-- Notif Header --}}
    <div class="card">
        <div class="notification-header">
            <div class="notification-info">
                <h2>Notifications</h2>
                <small class="notification-total">
                    {{ $notifications->total() }} total notifications
                </small>
            </div>

            @php
                $hasUnread = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->exists();
            @endphp

            <div style="display:flex; gap:8px;">
                
                @if($hasUnread)
                    <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="mark-all-btn">
                            Mark All as Read
                        </button>
                    </form>
                @endif

                @if($notifications->total() > 0)
                    <form method="POST"
                        action="{{ route('notifications.destroyAll') }}"
                        onsubmit="return confirm('Delete all notifications?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="delete-all-btn">
                            Delete All
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>

    <div class="notification-filters">
        @foreach(['all' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $key => $label)
            <a href="?filter={{ $key }}&type={{ $type ?? '' }}"
                class="filter-tab {{ $filter === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

        {{-- Type --}}
        @foreach([
            'like' => '👍 Like',
            'comment' => '💬 Comment',
            'repost' => '🔁 Repost',
            'mention' => '@ Mention'
        ] as $key => $label)

            <a href="?filter={{ $filter }}&type={{ $key }}"
                class="type-filter-tab {{ ($type ?? '') === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Notification List --}}
    <div>
        <h2>All Notifications</h2>
        @forelse($notifications as $notification)
            <div class="notif-card {{ $notification->is_read ? 'read' : 'unread' }}">
                <div class="notif-body">
                    <span class="notif-badge badge-{{ $notification->type }}">{{ strtoupper($notification->type) }}</span>
                    <div class="notif-message">{{ $notification->message }}</div>
                    
                    @if($notification->tweet_id || $notification->relatedUser)
                        <div class="notif-links">

                            @if($notification->tweet_id)
                                <a href="{{ route('tweets.show', $notification->tweet_id) }}"
                                    class="notif-link tweet-link">
                                    📄 View Tweet
                                </a>
                            @endif

                            @if($notification->relatedUser)
                                <a href="{{ route('profile.show', $notification->relatedUser->username) }}"
                                    class="notif-link user-link">
                                    👤 {{ $notification->relatedUser->username }}
                                </a>
                            @endif

                        </div>
                    @endif
                    
                    <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
                </div>

                <div class="notif-actions">
                    @if(!$notification->is_read)
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn-read">Mark as Read</button>
                        </form>
                    @endif
        
                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>  
            </div>  
        @empty
            <div class="card">
                <p class="empty-state">No notifications yet.</p>
            </div>
        @endforelse
    </div>

    {{ $notifications->links() }}

</div>
</body>
</html>
