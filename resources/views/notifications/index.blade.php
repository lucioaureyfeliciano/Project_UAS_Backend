<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
</head>
<body>
 
<a href="/dashboard">← Back to Dashboard</a>
 
<h1>Notifications</h1>
 
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
 
@forelse($notifications as $notification)
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
 
        <p>{{ $notification->message }}</p>
 
        <small>
            Type: {{ $notification->type }} |
            {{ $notification->created_at->diffForHumans() }} |
            {{ $notification->is_read ? 'Read' : 'Unread' }}
        </small>
 
        <br>
 
        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
            @csrf
            @method('PUT')
            <button type="submit">Mark as Read</button>
        </form>
 
        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
 
    </div>
@empty
    <p>No notifications yet.</p>
@endforelse
 
{{ $notifications->links() }}
 
</body>
</html>