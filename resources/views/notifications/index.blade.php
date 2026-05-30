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

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #a3cfbb;
        }

        h2 {
            margin-top: 0;
        }
    </style>   
</head>
<body>

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Dashboard</a>
    <div>🔔 Notifications</div>
    <div></div>
</div>

<div class="container">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    
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

            @if($hasUnread)
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="mark-all-btn">Mark All as Read </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Notification List --}}
    <div>
        <h2>All Notifications</h2>
        @forelse($notifications as $notification)
            <div class="notif-card {{ $notification->is_read ? 'read' : 'unread' }}">
                <div class="notif-body">
                    <span class="notif-badge badge-{{ $notification->type }}">{{ strtoupper($notification->type) }}</span>
                    <div class="notif-message">{{ $notification->message }}</div>
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