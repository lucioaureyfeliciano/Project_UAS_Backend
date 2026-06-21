<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>

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
        }

        .container {
            width: 700px;
            margin: 20px auto;
        }

        .chat-box {
            background: white;
            border-radius: 10px;
            padding: 15px;
            min-height: 500px;
        }

        .message {
            margin-bottom: 12px;
            display: flex;
        }

        .sent {
            justify-content: flex-end;
        }

        .received {
            justify-content: flex-start;
        }

        .bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
        }

        .sent .bubble {
            background: #3490dc;
            color: white;
        }

        .received .bubble {
            background: #e9ecef;
        }

        .message-time {
            font-size: 11px;
            margin-top: 5px;
            opacity: 0.7;
        }

        .send-form {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        textarea {
            flex: 1;
            resize: none;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #2779bd;
        }

        .back-btn {
            color: white;
            text-decoration: none;
        }

        .chat-link {
            color: inherit;
            text-decoration: underline;
            word-break: break-all;
        }

        .sent .chat-link {
            color: #fff;
        }

        .received .chat-link {
            color: #3490dc;
        }

        .shared-tweet-card {
            background: white;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ddd;
            max-width: 320px;
        }

        .shared-tweet-user {
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .shared-tweet-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #222;
        }

        .shared-tweet-content {
            font-size: 13px;
            color: #555;
            line-height: 1.5;
        }
    </style>
</head>
<body>
@include('components.toast')

<div class="navbar">

    <div>
        Chat with {{ $user->username }}
    </div>

    <a href="/messages/inbox" class="back-btn">
        ← Inbox
    </a>

</div>

<div class="container">

    <div class="chat-box">

        @forelse($messages as $message)

            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">

                <div class="bubble">

                    @php
                        preg_match('/\[TWEET:(\d+)\]/', $message->message, $matches);
                        $tweetId = $matches[1] ?? null;

                        $cleanMessage = $tweetId
                            ? trim(preg_replace('/\[TWEET:\d+\]\s*/', '', $message->message))
                            : $message->message;

                    @endphp
                    
                    @if($tweetId)
                        @php
                            $sharedTweet = \App\Models\Tweet::with('user')->find($tweetId);
                        @endphp 

                        @if($sharedTweet)
                            <a href="{{ route('tweets.show', $sharedTweet->id) }}"
                                style="text-decoration:none; color:inherit;">

                                <div class="shared-tweet-card">

                                    <div class="shared-tweet-user">
                                        👤 {{ $sharedTweet->user?->username }}
                                    </div>

                                    <div class="shared-tweet-title">
                                        {{ $sharedTweet->title }}
                                    </div>

                                    <div class="shared-tweet-content">
                                        {{ Str::limit($sharedTweet->content, 120) }}
                                    </div>

                                </div>
                            </a>
                        @endif
                    @endif

                    @if($cleanMessage)
                        <div class="chat-text">
                            {!! \App\Models\Message::linkify($cleanMessage) !!}
                        </div>
                    @endif

                    <div class="message-time">
                        {{ $message->created_at->format('d M Y H:i') }}

                            @if($message->sender_id == auth()->id())

                                @if($message->read_at)

                                    · Seen {{ \Carbon\Carbon::parse($message->read_at)->format('H:i') }}

                                @else

                                    · Sent

                                @endif

                            @endif
                    </div>

                </div>

            </div>

        @empty

            <p>
                Start your conversation 👋
            </p>

        @endforelse

    </div>

    <form
        method="POST"
        action="/messages"
        class="send-form"
    >
        @csrf

        <input
            type="hidden"
            name="receiver_id"
            value="{{ $user->id }}"
        >

        <textarea
            name="message"
            rows="3"
            placeholder="Type your message..."
            required
        ></textarea>

        <button type="submit">
            Send
        </button>

    </form>

</div>

</body>
</html>
