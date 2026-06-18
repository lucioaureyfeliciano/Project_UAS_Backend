<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            width: 550px;
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .tweet-ref {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3490dc;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            resize: vertical;
            box-sizing: border-box;
            font-size: 14px;
        }

        .submit-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 12px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 4px;
        }
 
        .char-counter {
            text-align: right;
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .char-counter.limit {
            color: #e74c3c;
            font-weight: bold;
        }

        .mention-autocomplete-wrapper {
            position: relative;
        }

        .mention-autocomplete-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            max-height: 200px;
            overflow-y: auto;
            z-index: 50;
            padding: 6px 0;
        }

        .mention-autocomplete-dropdown.show {
            display: block;
        }

        .mention-suggestion {
            padding: 10px 12px;
            cursor: pointer;
            color: #333;
        }

        .mention-suggestion:hover {
            background: #3490dc;
            color: white;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="{{ route('tweets.show', $tweet->id) }}" class="back-btn">← Back to Tweet</a>
    <div>Add Comment</div>
    <div></div>
</div>

<div class="container">
    <div class="card">
        <h2 style="margin-top:0;">Add a Comment</h2>

        <div class="tweet-ref">
            <strong>{{ $tweet->title }}</strong><br>
            <span style="font-size:13px; color:#666;">
                by {{ $tweet->user?->username ?? 'Unknown' }}
            </span>
        </div>

        <form method="POST" action="{{ route('comments.store', $tweet->id) }}">
            @csrf

            <label for="content">Your Comment</label>

            <div class="mention-autocomplete-wrapper">
                <textarea
                    id="comment-box"
                    class="mention-autocomplete-input"
                    name="content"
                    rows="4"
                    maxlength="280"
                    placeholder="Write your comment..."
                    required>{{ old('content') }}</textarea>
                <div class="mention-autocomplete-dropdown"></div>
            </div>

            <div id="counter" class="char-counter">0/280</div>
            
            @error('content')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="submit-btn">
                Post Comment
            </button>
        </form>
    </div>
</div>
<script>
const box = document.getElementById('comment-box');
const counter = document.getElementById('counter');

if (box && counter) {
    box.addEventListener('input', () => {
        const len = box.value.length;
        counter.innerText = `${len}/280`;

        if (len >= 250) {
            counter.classList.add('limit');
        } else {
            counter.classList.remove('limit');
        }
    });
}

function setupMentionAutocomplete(textarea) {
    const wrapper = textarea.closest('.mention-autocomplete-wrapper');
    const dropdown = wrapper.querySelector('.mention-autocomplete-dropdown');
    let debounceTimer = null;
    let activeMention = null;
    let requestId = 0;
    let ignoreNextInput = false;

    const hideDropdown = () => {
        dropdown.classList.remove('show');
        dropdown.innerHTML = '';
        activeMention = null;
    };

    const findActiveMention = () => {
        const cursorPosition = textarea.selectionStart;
        const textBeforeCursor = textarea.value.slice(0, cursorPosition);
        const match = textBeforeCursor.match(/(^|[\s(])@([A-Za-z0-9_]{1,30})$/);

        if (!match) {
            return null;
        }

        return {
            keyword: match[2],
            start: cursorPosition - match[2].length - 1,
            end: cursorPosition
        };
    };

    const insertMention = (username) => {
        if (!activeMention) {
            return;
        }

        textarea.value =
            textarea.value.slice(0, activeMention.start) +
            `@${username}` +
            textarea.value.slice(activeMention.end);

        const cursorPosition = activeMention.start + username.length + 1;
        textarea.focus();
        textarea.setSelectionRange(cursorPosition, cursorPosition);
        ignoreNextInput = true;
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        hideDropdown();
    };

    const renderSuggestions = (users) => {
        if (!users.length) {
            hideDropdown();
            return;
        }

        dropdown.innerHTML = '';

        users.forEach((user) => {
            const item = document.createElement('div');
            item.className = 'mention-suggestion';
            item.textContent = user.username;
            item.addEventListener('mousedown', (event) => {
                event.preventDefault();
                insertMention(user.username);
            });
            dropdown.appendChild(item);
        });

        dropdown.classList.add('show');
    };

    textarea.addEventListener('input', () => {
        if (ignoreNextInput) {
            ignoreNextInput = false;
            hideDropdown();
            return;
        }

        clearTimeout(debounceTimer);

        const mention = findActiveMention();
        if (!mention) {
            hideDropdown();
            return;
        }

        activeMention = mention;

        debounceTimer = setTimeout(() => {
            const currentRequest = ++requestId;

            fetch(`/mentions/search?q=${encodeURIComponent(mention.keyword)}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(users => {
                    if (currentRequest === requestId) {
                        renderSuggestions(users);
                    }
                })
                .catch(() => hideDropdown());
        }, 250);
    });

    textarea.addEventListener('keydown', () => {
        setTimeout(() => {
            if (!findActiveMention()) {
                hideDropdown();
            }
        }, 0);
    });

    document.addEventListener('click', (event) => {
        if (!wrapper.contains(event.target)) {
            hideDropdown();
        }
    });
}

document.querySelectorAll('.mention-autocomplete-input').forEach(setupMentionAutocomplete);
</script>
</body>
</html>
