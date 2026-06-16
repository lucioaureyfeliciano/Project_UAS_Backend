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
            position: relative;
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

        .message-menu {
            position: absolute;
            top: 5px;
            right: -10px;
        }

        .sent .message-menu {
            opacity: 0;
            transition: 0.2s;
        }

        .sent:hover .message-menu {
            opacity: 1;
        }

        .menu-btn {
            background: transparent;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 12px;
            padding: 4px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 20px;
            background: white;
            min-width: 120px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.15);
        }

        .message-menu:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu button {
            width: 100%;
            border: none;
            background: white;
            color: black;
            text-align: left;
            padding: 10px;
            cursor: pointer;
        }

        .dropdown-menu button:hover {
            background: #f5f5f5;
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

    </style>
</head>

<script>

function openEdit(id)
{
    let form = document.getElementById(
        'edit-' + id
    );

    if(form.style.display === 'none')
    {
        form.style.display = 'block';
    }
    else
    {
        form.style.display = 'none';
    }
}

</script>

<body>

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

                @if(
                    $message->sender_id == auth()->id()
                    &&
                    $message->created_at->diffInMinutes(now()) <= 5
                )

                    <div class="message-menu">

                        <button class="menu-btn">
                            ▼
                        </button>

                        <div class="dropdown-menu">

                            <button
                                type="button"
                                onclick="openEdit({{ $message->id }})"
                            >
                                Edit Message
                            </button>

                        </div>

                    </div>

                @endif


                <div class="bubble">

                    <div>

                        {{ $message->message }}

                        @if($message->edited_at)

                            <small
                                style="
                                    display:block;
                                    margin-top:4px;
                                    opacity:.7;
                                "
                            >
                                (edited)
                            </small>

                        @endif

                    </div>

                    @if(
                        $message->sender_id == auth()->id()
                        &&
                        $message->created_at->diffInMinutes(now()) <= 5
                    )

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

                @if($message->sender_id == auth()->id())

                    <div
                        id="edit-{{ $message->id }}"
                        style="
                            display:none;
                            margin-top:5px;
                            margin-bottom:10px;
                        "
                    >

                        <form
                            method="POST"
                            action="/messages/{{ $message->id }}"
                        >

                            @csrf
                            @method('PUT')

                            <textarea
                                name="message"
                                rows="2"
                                style="width:100%;"
                            >{{ $message->message }}</textarea>

                            <button
                                type="submit"
                                style="margin-top:5px;"
                            >
                                Save
                            </button>

                        </form>

                    </div>

                @endif

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