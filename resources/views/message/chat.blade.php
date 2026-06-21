<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            color: white;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
        }

        .container {
            width: 700px;
            margin: 20px auto;
        }

        .chat-box {
            background: white;
            border-radius: 12px;
            padding: 16px;
            min-height: 500px;
        }

        .message {
            margin-bottom: 14px;
            display: flex;
            flex-direction: column;
        }

        .sent {
            align-items: flex-end;
        }

        .received {
            align-items: flex-start;
        }

        .bubble-wrap {
            display: flex;
            align-items: flex-end;
            gap: 6px;
            max-width: 75%;
        }

        .sent .bubble-wrap {
            flex-direction: row-reverse;
        }

        .bubble {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
            min-width: 70px;
        }

        .sent .bubble {
            background: #3490dc;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .received .bubble {
            background: #e9ecef;
            color: #111;
            border-bottom-left-radius: 4px;
        }

        .bubble small {
            display: block;
            margin-top: 4px;
            opacity: .65;
            font-size: 11px;
            white-space: nowrap;
        }

        .message-time {
            font-size: 11px;
            margin-top: 5px;
            color: #888;
        }

        .sent .message-time {
            text-align: right;
        }

        .message-menu {
            position: relative;
            opacity: 0;
            transition: opacity 0.15s;
            flex-shrink: 0;
        }

        .sent:hover .message-menu,
        .bubble-wrap:hover .message-menu {
            opacity: 1;
        }

        .menu-btn {
            background: transparent;
            border: none;
            color: #666;
            cursor: pointer;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: background 0.15s;
        }

        .menu-btn:hover {
            background: #e9ecef;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            bottom: calc(100% + 4px);
            right: 0;
            background: white;
            min-width: 140px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .12);
            overflow: hidden;
            z-index: 10;
        }

        .message-menu:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu button {
            width: 100%;
            border: none;
            background: white;
            color: #111;
            text-align: left;
            padding: 9px 12px;
            cursor: pointer;
            font-size: 13px;
        }

        .dropdown-menu button:hover {
            background: #f5f5f5;
        }

        .dropdown-menu button.delete-btn {
            color: #e3342f;
        }

        .dropdown-menu button.delete-btn:hover {
            background: #fdecea;
        }

        .edit-form {
            margin-top: 8px;
            width: min(70%, 400px);
        }

        .sent .edit-form {
            align-self: flex-end;
        }

        .edit-form textarea {
            width: 100%;
            resize: vertical;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            font-size: 13px;
            min-height: 60px;
        }

        .edit-form button {
            margin-top: 6px;
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .edit-form button:hover {
            background: #2779bd;
        }

        .send-form {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .send-form textarea {
            flex: 1;
            resize: none;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .send-form textarea:focus {
            outline: none;
            border-color: #3490dc;
        }

        .send-form button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 0 20px;
            height: 52px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .send-form button:hover {
            background: #2779bd;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            opacity: .9;
            font-size: 14px;
        }
    </style>
</head>

<script>
function openEdit(id) {
    var el = document.getElementById('edit-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>

<body>
@include('components.toast')

<div class="navbar">
    <div>Chat with {{ $user->username }}</div>
    <a href="/messages/inbox" class="back-btn">← Inbox</a>
</div>

<div class="container">

    <div class="chat-box">

        @forelse($messages as $message)

            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">

                <div class="bubble-wrap">

                    @if($message->sender_id == auth()->id())
                        <div class="message-menu">
                            <button class="menu-btn" type="button">⋮</button>
                            <div class="dropdown-menu">
                                <button type="button" onclick="openEdit({{ $message->id }})">
                                    Edit pesan
                                </button>
                                <button type="button" class="delete-btn" data-id="{{ $message->id }}">
                                    Hapus pesan
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="bubble">
                        {!! nl2br(e($message->message)) !!}
                        @if($message->edited_at)
                            <small>(edited)</small>
                        @endif
                    </div>

                </div>

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

                @if($message->sender_id == auth()->id())
                    <div id="edit-{{ $message->id }}" class="edit-form" style="display:none;">
                        <form method="POST" action="/messages/{{ $message->id }}">
                            @csrf
                            @method('PUT')
                            <textarea name="message" rows="2">{{ $message->message }}</textarea>
                            <button type="submit">Simpan</button>
                        </form>
                    </div>
                @endif

            </div>

        @empty
            <p>Start your conversation 👋</p>
        @endforelse

    </div>

    <div class="send-form">
        <textarea id="message-input" rows="3" placeholder="Ketik pesan..." required></textarea>
        <button type="button" id="send-btn">Kirim</button>
    </div>

</div>

<script>
const csrfToken = '{{ csrf_token() }}';
const receiverId = '{{ $user->id }}';
const chatBox = document.querySelector('.chat-box');
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');

function formatTime(dateStr) {
    const d = new Date(dateStr);
    const day = String(d.getDate()).padStart(2, '0');
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    return `${day} ${months[d.getMonth()]} ${d.getFullYear()} ${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
}

function nl2br(str) {
    return str.replace(/\n/g, '<br>');
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function appendMessage(text, time, id) {
    const empty = chatBox.querySelector('p');
    if (empty) empty.remove();

    const editForm = id ? `
        <div id="edit-${id}" class="edit-form" style="display:none;">
            <form class="edit-ajax-form" data-id="${id}">
                <textarea name="message" rows="2">${escapeHtml(text)}</textarea>
                <button type="submit">Simpan</button>
            </form>
        </div>` : '';

    const menu = id ? `
        <div class="message-menu">
            <button class="menu-btn" type="button">⋮</button>
            <div class="dropdown-menu">
                <button type="button" onclick="openEdit(${id})">Edit pesan</button>
                <button type="button" class="delete-btn" data-id="${id}">Hapus pesan</button>
            </div>
        </div>` : '';

    const html = `
        <div class="message sent">
            <div class="bubble-wrap">
                ${menu}
                <div class="bubble">${nl2br(escapeHtml(text))}</div>
            </div>
            <div class="message-time">${time} · Sent</div>
            ${editForm}
        </div>`;

    chatBox.insertAdjacentHTML('beforeend', html);
    chatBox.scrollTop = chatBox.scrollHeight;
}

async function sendMessage() {
    const text = messageInput.value.trim().replace(/^\n+|\n+$/g, '');
    if (!text) return;

    sendBtn.disabled = true;
    messageInput.disabled = true;

    try {
        const res = await fetch('/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ receiver_id: receiverId, message: text }),
        });

        const responseText = await res.text();

        let data = null;
        try {
            data = JSON.parse(responseText);
        } catch (_) {
            const time = formatTime(new Date().toISOString());
            appendMessage(text, time, null);
            messageInput.value = '';
            return;
        }

        if (!res.ok) {
            const errMsg = data?.message ?? Object.values(data?.errors ?? {})?.[0]?.[0] ?? 'Gagal mengirim';
            alert(errMsg);
            return;
        }

        const time = formatTime(data.created_at ?? new Date().toISOString());
        appendMessage(text, time, data.id ?? null);
        messageInput.value = '';
    } catch (e) {
        alert('Network error: ' + e.message);
    } finally {
        sendBtn.disabled = false;
        messageInput.disabled = false;
        messageInput.focus();
    }
}

sendBtn.addEventListener('click', sendMessage);

messageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

document.addEventListener('submit', async function(e) {
    const form = e.target;
    if (!form.closest('.edit-form')) return;
    e.preventDefault();

    const editDiv = form.closest('.edit-form');
    const messageEl = editDiv.closest('.message');
    const textarea = form.querySelector('textarea[name="message"]');
    const btn = form.querySelector('button[type="submit"]');
    const text = textarea.value.trim();
    if (!text) return;

    const id = form.dataset.id
        ?? form.action.split('/messages/')[1]?.split('?')[0];

    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const res = await fetch('/messages/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: text, _method: 'PUT' }),
        });

        if (!res.ok) throw new Error('Gagal');

        const bubble = messageEl.querySelector('.bubble');
        bubble.innerHTML = nl2br(escapeHtml(text));

        let label = bubble.querySelector('small');
        if (!label) {
            label = document.createElement('small');
            bubble.appendChild(label);
        }
        label.textContent = '(edited)';

        textarea.value = text;
        editDiv.style.display = 'none';

    } catch (err) {
        alert('Gagal menyimpan, hanya bisa mengedit pesan yang terkirim dibawah 5 menit.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Simpan';
    }
});

document.addEventListener('click', async function(e) {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;

    const id = btn.dataset.id;
    if (!confirm('Yakin ingin menghapus pesan ini?')) return;

    const messageEl = btn.closest('.message');

    try {
        const res = await fetch('/messages/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ _method: 'DELETE' }),
        });

        if (!res.ok) throw new Error('Gagal menghapus');

        messageEl.remove();

        if (!chatBox.querySelector('.message')) {
            chatBox.insertAdjacentHTML('beforeend', '<p>Start your conversation 👋</p>');
        }
    } catch (err) {
        alert('Gagal menghapus pesan.');
    }
});

chatBox.scrollTop = chatBox.scrollHeight;
</script>
</body>
</html>