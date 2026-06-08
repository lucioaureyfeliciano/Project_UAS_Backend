<!DOCTYPE html>
<html>

<head>
    <title>Search Users</title>

    <style>
        body {
            font-family: Arial;
            background: #f3f3f3;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            padding: 15px;
        }

        .back-btn {
            color: white;
            text-decoration: none;
        }

        .container {
            width: 75%;
            max-width: 900px;
            margin: 30px auto;
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .user-card {
            background: #b4cde5;
            border: 1px solid #444;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .username-link {
            text-decoration: none;
            color: black;
        }

        .username-link:hover {
            color: #2f7cc2;
        }

        .avatar {
            width: 80px;
            height: 80px;

            border-radius: 50%;

            background: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 34px;

            border: 2px solid rgba(255, 255, 255, .8);
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

        <div class="search-box">

            <form method="GET">

                <input type="text" name="search" placeholder="Search username..." value="{{ $keyword }}" style="
                    width:80%;
                    padding:10px;
                ">

                <button type="submit">
                    Search
                </button>

            </form>

        </div>

        @forelse($users as $user)

            <div class="user-card">

                <a href="/profile/{{ $user->username }}" class="username-link">
                    <div class="avatar">
                        👤
                    </div>
                </a>

                <p>
                    {{ $user->description ?? 'No description' }}
                </p>

            </div>

        @empty

            <p>No users found.</p>

        @endforelse

    </div>

</body>

</html>