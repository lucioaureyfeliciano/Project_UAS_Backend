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

            <textarea
                id="comment-box"
                name="content"
                rows="4"
                maxlength="280"
                placeholder="Write your comment..."
                required>{{ old('content') }}</textarea>

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
</script>
</body>
</html>