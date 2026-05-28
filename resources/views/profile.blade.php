<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>

    <style>

        body {
            font-family: Arial;
            background: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #3b8edb;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        .success-alert {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #a3cfbb;
        }

        .container {
            width: 75%;
            max-width: 900px;
            margin: 35px auto;
        }

        .profile-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-left h1 {
            margin: 0;
            font-size: 32px;
        }

        .description-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .description-text {
            font-size: 16px;
            color: #444;
            white-space: pre-wrap;
            word-break: break-word;
            overflow-wrap: anywhere;
            max-width: 100%;
            line-height: 1.6;
        }

        .profile-edit-row {
            margin-top: 10px;
            font-size: 13px;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .edit-description-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            color: #555;
            padding: 0;
        }

        .edit-description-btn:hover {
            text-decoration: underline;
        }

        .stats {
            display: flex;
            gap: 28px;
            justify-content: center;
            align-items: center;
        }

        .stat-box {
            text-align: center;
        }

        .stat-title {
            font-size: 15px;
            color: black;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: black;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .tweet-card {
            background: white;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 20px;
        }

        .tweet-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tweet-info {
            font-size: 13px;
            color: #555;
            margin-bottom: 12px;
        }

        .tweet-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 14px;
            color: black;
        }

        .tweet-content {
            font-size: 15px;
            color: black;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .tweet-actions {
            display: flex;
            justify-content: flex-end;
            gap: 25px;
            color: black;
            font-size: 15px;
        }

        .tweet-menu-container {
            position: relative;
        }

        .tweet-menu-btn {
            border: none;
            background: transparent;
            font-size: 18px;
            cursor: pointer;
        }

        .tweet-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            min-width: 120px;
        }

        .tweet-dropdown button {
            width: 100%;
            border: none;
            background: white;
            padding: 12px;
            text-align: left;
            cursor: pointer;
        }

        .tweet-dropdown button:hover {
            background: #f5f5f5;
        }

        .tweet-menu-container:hover .tweet-dropdown {
            display: block;
        }

        .edit-modal {
            display: none;
            margin-top: 20px;
            background: #fafafa;
            padding: 20px;
            border-radius: 15px;
        }

        .edit-modal input,
        .edit-modal textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        .description-modal {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .description-modal textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            resize: none;
            box-sizing: border-box;
        }

        .description-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .save-btn {
            background: #b7e4c7;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .cancel-btn {
            background: #f5c2c7;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

    </style>

</head>
<body>

<div class="navbar">

    <a href="/dashboard" class="back-btn">
        ← Back
    </a>

</div>

<div class="container">
    @if(session('success'))

        <div class="success-alert" id="successAlert">
            {{ session('success') }}
        </div>

    @endif


    <div class="profile-card">

        <div class="profile-left">

            <h1>{{ $user->username }}</h1>

            <div class="profile-edit-row">
                <button
                    class="edit-description-btn"
                    onclick="openDescriptionEdit()"
                >
                    [edit]
                </button>
            </div>

            <div class="description-section">
                <div class="description-text">
                    {{ $user->description ?? '[Deskripsi]' }}
                </div>
            </div>

        </div>

        <div class="stats">

            <div class="stat-box">
                <div class="stat-title">Following</div>
                <div class="stat-number">0</div>
            </div>

            <div class="stat-box">
                <div class="stat-title">Followers</div>
                <div class="stat-number">0</div>
            </div>

            <div class="stat-box">
                <div class="stat-title">Likes</div>
                <div class="stat-number">

                    {{ $tweets->sum(function($tweet) {
                        return $tweet->likes->count();
                    }) }}

                </div>
            </div>

            <div class="stat-box">
                <div class="stat-title">Dislikes</div>
                <div class="stat-number">

                    {{ $tweets->sum(function($tweet) {
                        return $tweet->dislikes->count();
                    }) }}

                </div>
            </div>

            <div class="stat-box">
                <div class="stat-title">Tweets</div>
                <div class="stat-number">
                    {{ $tweets->count() }}
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-title">Repost</div>
                <div class="stat-number">

                    {{ $tweets->sum(function($tweet) {
                        return $tweet->reposts->count();
                    }) }}

                </div>
            </div>

        </div>

    </div>

    <div class="description-modal" id="descriptionModal">

        <form action="/profile/update-description" method="POST">

            @csrf

            <textarea
                name="description"
                rows="4"
                placeholder="Write your description..."
            >{{ $user->description }}</textarea>

            <div class="description-actions">

                <button type="submit" class="save-btn">
                    Save
                </button>

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeDescriptionEdit()"
                >
                    Cancel
                </button>

            </div>

        </form>

    </div>

    <h1 class="section-title">Your Tweets</h1>

    @foreach ($tweets as $tweet)

        <div class="tweet-card">

            <div class="tweet-top">

                <div class="tweet-info">

                    {{ $user->username }}
                    •
                    posted {{ $tweet->created_at->diffForHumans() }}

                </div>

                <div class="tweet-menu-container">

                    <button class="tweet-menu-btn">
                        •••
                    </button>

                    <div class="tweet-dropdown">

                        <button onclick="openEdit({{ $tweet->id }})">
                            Edit
                        </button>

                        <form action="/tweets/{{ $tweet->id }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                style="color:red;"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            <div class="tweet-title">
                {{ $tweet->title }}
            </div>

            <div class="tweet-content">
                {{ $tweet->content }}
            </div>

            <div class="tweet-actions">

                <div>
                    👍 {{ $tweet->likes->count() }}
                </div>

                <div>
                    👎 {{ $tweet->dislikes->count() }}
                </div>

                <div>
                    🔁 {{ $tweet->reposts->count() }}
                </div>

            </div>

            <div class="edit-modal" id="edit-{{ $tweet->id }}">

                <form action="/tweets/{{ $tweet->id }}" method="POST">

                    @csrf
                    @method('PUT')

                    <input
                        type="text"
                        name="title"
                        value="{{ $tweet->title }}"
                    >

                    <textarea
                        name="content"
                        rows="4"
                    >{{ $tweet->content }}</textarea>

                    <div class="description-actions">

                        <button type="submit" class="save-btn">
                            Save
                        </button>

                        <button
                            type="button"
                            class="cancel-btn"
                            onclick="closeEdit({{ $tweet->id }})"
                        >
                            Cancel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endforeach

</div>

<script>

function openDescriptionEdit() {
    document.getElementById('descriptionModal').style.display = 'block';
}

function closeDescriptionEdit() {
    document.getElementById('descriptionModal').style.display = 'none';
}

function openEdit(id) {
    document.getElementById(`edit-${id}`).style.display = 'block';
}

function closeEdit(id) {
    document.getElementById(`edit-${id}`).style.display = 'none';
}

setTimeout(() => {

    const alertBox = document.getElementById('successAlert');

    if (alertBox) {

        alertBox.style.transition = '0.5s';
        alertBox.style.opacity = '0';

        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 500);

    }

}, 5000);

</script>

</body>
</html>