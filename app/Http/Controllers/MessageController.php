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


        $unreadCounts = [];

        foreach ($conversations as $conversation) {

            $otherUserId =
                $conversation->sender_id == $userId
                    ? $conversation->receiver_id
                    : $conversation->sender_id;

            $unreadCounts[$otherUserId] = Message::where(
                    'sender_id',
                    $otherUserId
                )
                ->where(
                    'receiver_id',
                    $userId
                )
                ->whereNull('read_at')
                ->count();
        }

        return view(
            'message.inbox',
            compact(
                'conversations',
                'unreadCounts'
            )
        );
    }

    public function chat($userId)
    {

        $user = User::findOrFail($userId);

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

            ->with(['sender', 'replyTo'])
            ->orderBy('created_at')
            ->get();

        $receiver = User::findOrFail($userId);

        return view(
            'message.chat',
            compact(
                'messages',
                'receiver',
                'user'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => preg_replace(
                '/^\s+|\s+$/u',
                '',
                $request->message
            ),
            'reply_to_id' => $request->reply_to_id
        ]);

        return response()->json($message, 201);
    }

    public function update(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);

        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        if ($message->created_at->diffInMinutes(now()) > 5) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Pesan hanya bisa diedit dalam 5 menit.'], 403);
            }
            return back()->with('error', 'Message can only be edited within 5 minutes.');
        }

        $request->validate(['message' => 'required|string']);

        $message->update([
            'message'   => $request->message,
            'edited_at' => now(),
            'read_at'   => null
        ]);

        if ($request->expectsJson()) {
            return response()->json($message);
        }

        return back()->with('success', 'Message updated.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id != auth()->id()) {
            abort(403);
        }

        $message->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Pesan berhasil dihapus.']);
        }

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

        $unreadCounts = [];

        foreach ($conversations as $conversation) {

            $otherUserId =
                $conversation->sender_id == auth()->id()
                    ? $conversation->receiver_id
                    : $conversation->sender_id;

            $unreadCounts[$otherUserId] = Message::where(
                    'sender_id',
                    $otherUserId
                )
                ->where(
                    'receiver_id',
                    auth()->id()
                )
                ->whereNull('read_at')
                ->count();
        }

        return view('message.inbox', compact(
            'users',
            'conversations',
            'keyword',
            'unreadCounts'
        ));
    }

    public function shareToChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|max:1000',
        ]);

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        return back()->with('success', 'Shared to chat!');
    }
}