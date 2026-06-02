<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->with(['relatedUser', 'tweet'])
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
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
    
}