<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function inbox()
    {
        $userId = auth()->id();

        $messages = Message::with(['sender', 'receiver'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        $conversations = $messages
            ->groupBy(function ($message) use ($userId) {

                return $message->sender_id == $userId
                    ? $message->receiver_id
                    : $message->sender_id;

            })
            ->map(function ($group) {

                return $group->first(); // pesan terbaru

            });

        return view('message.inbox', compact('conversations'));
    }

    public function chat($userId)
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now()
            ]);

        $messages = Message::where(function ($query) use ($userId) {

                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $userId);

            })

            ->orWhere(function ($query) use ($userId) {

                $query->where('sender_id', $userId)
                    ->where('receiver_id', auth()->id());

            })

            ->with('sender')
            ->orderBy('created_at')
            ->get();

        $receiver = User::findOrFail($userId);

        return view(
            'message.chat',
            compact(
                'messages',
                'receiver'
            )
        );
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

        $messages = Message::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        $conversations = $messages
            ->groupBy(function ($message) {

                return $message->sender_id == auth()->id()
                    ? $message->receiver_id
                    : $message->sender_id;

            })
            ->map(function ($conversation) {

                return $conversation->first();

            });

        return view('message.inbox', compact(
            'users',
            'conversations',
            'keyword'
        ));
    }
}