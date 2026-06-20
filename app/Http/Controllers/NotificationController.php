<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $type   = request('type');

        $query = Notification::where('user_id', auth()->id())
            ->with(['relatedUser', 'tweet'])
            ->latest();

        if ($filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($filter === 'read') {
            $query->where('is_read', true);
        }

        if ($type && in_array($type, ['like', 'comment', 'repost', 'mention'])) {
            $query->where('type', $type);
        } 

        $notifications = $query->paginate(15);

        return view('notifications.index', compact('notifications', 'filter', 'type'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notif->update(['is_read' => true]);
        return back()->with('success', 'Marked as read');
    }

    public function destroy($id)
    {
        $notif = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notif->delete();
        return back()->with('success', 'Deleted!');
    }

    public function show($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        return view('notifications.show', compact('notification'));
    }
    
    public function markAllAsRead()
    {
        \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroyAll()
    {
        \App\Models\Notification::where('user_id', auth()->id())->delete();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'All notifications deleted!');
    }
}