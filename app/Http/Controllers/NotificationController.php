<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notifications = Notification::where('user_id', $id)
            ->with(['relatedUser', 'tweet'])
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function unread($id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notifications = Notification::where('user_id', $id)
            ->where('is_read', false)
            ->with(['relatedUser', 'tweet'])
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,comment,follow,repost',
            'message' => 'required|string',
            'related_user_id' => 'nullable|exists:users,id',
            'tweet_id' => 'nullable|exists:tweets,id',
        ]);

        $notification = Notification::create([
            'user_id' => $id,
            'type' => $validated['type'],
            'message' => $validated['message'],
            'related_user_id' => $validated['related_user_id'] ?? null,
            'tweet_id' => $validated['tweet_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Notification created successfully',
            'notification' => $notification
        ], 201);
    }

    public function markAsRead($id, $notif_id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification = Notification::where('user_id', $id)->findOrFail($notif_id);
        $notification->update(['is_read' => true]);

        return response()->json([
            'message' => 'Notification marked as read',
            'notification' => $notification
        ]);
    }

    public function destroy($id, $notif_id)
    {
        if (auth()->id() != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification = Notification::where('user_id', $id)->findOrFail($notif_id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
