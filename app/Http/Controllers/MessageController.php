<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function inbox()
    {
        $messages = Message::where('receiver_id', auth()->id())
            ->with('sender')
            ->latest()
            ->get();

        return view('message.inbox', compact('messages'));
    }

    public function chat($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at')
        ->get();

        $user = User::findOrFail($userId);

        return view('message.chat', compact('messages', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|max:1000'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id != auth()->id()) {
            abort(403);
        }

        $message->update([
            'message' => $request->message
        ]);

        return back();
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id != auth()->id()) {
            abort(403);
        }

        $message->delete();

        return back();
    }

    public function search(Request $request)
    {
        $keyword = $request->search;

        $users = User::where('username', 'like', "%{$keyword}%")
            ->where('id', '!=', auth()->id())
            ->get();

        $messages = Message::where('receiver_id', auth()->id())
            ->with('sender')
            ->latest()
            ->get();

        return view('message.inbox', compact(
            'users',
            'messages',
            'keyword'
        ));
    }
}