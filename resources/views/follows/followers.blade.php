<!DOCTYPE html>
<html>

<head>
    <title>Followers</title>

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

        .container {
            width: 75%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .header-card {
            background: #b4cde5;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
        }

        .header-card h1 {
            margin: 0;
            font-size: 32px;
        }

        .header-card p {
            margin-top: 10px;
            color: #444;
        }

        .user-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .user-card {
            background: #b4cde5;
            border: 1px solid #444;
            border-radius: 15px;
            padding: 20px;

            transition: 0.25s;
        }

        .user-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0px 5px 15px rgba(0, 0, 0, 0.15);
        }

        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .user-info {
            display: flex;
            gap: 15px;
            align-items: center;
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

        .since {
            margin-top: 10px;
            font-size: 13px;
            color: #555;
        }

        .user-link {
            text-decoration: none;
            color: black;
            font-size: 22px;
            font-weight: bold;
        }

        .user-link:hover {
            color: #3b8edb;
        }

        .bio {
            margin-top: 5px;
            color: #444;
        }

        .menu-container {
            position: relative;
        }

        .menu-btn {
            border: none;
            background: transparent;
            font-size: 22px;
            cursor: pointer;
        }

        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            min-width: 150px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.15);
            z-index: 100;
        }

        .dropdown button,
        .dropdown a {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            background: white;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        .dropdown button:hover,
        .dropdown a:hover {
            background: #f2f2f2;
        }

        .menu-container:hover .dropdown {
            display: block;
        }

        .empty-state {
            text-align: center;
            margin-top: 50px;
            color: #777;
        }

        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;

            width: 45px;
            height: 45px;

            border: none;
            border-radius: 50%;

            background: #3b8edb;
            color: white;

            font-size: 20px;
            cursor: pointer;

            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);

            z-index: 999;
        }

        #scrollTopBtn:hover {
            background: #2f7cc2;
        }
    </style>

</head>

<body>

    <div class="navbar">

        <a href="{{ route('profile.show', $user->username) }}" class="back-btn">
            ← Back
        </a>

    </div>

    <div class="container">

        <div class="header-card">

            <h1>Followers</h1>

            <p>
                {{ $user->followers->count() }}
                followers
            </p>

        </div>

        @if($user->followers->count())

            <div class="user-grid">

                @foreach($user->followers as $follow)

                    <div class="user-card">

                        <div class="user-header">

                            <div class="user-info">

                                <div class="avatar">
                                    👤
                                </div>

                                <div>

                                    <a href="{{ route('profile.show', $follow->follower->username) }}" class="user-link">
                                        {{ $follow->follower->username }}
                                    </a>

                                    <div class="bio">
                                        {{ $follow->follower->description ?? 'No bio yet' }}
                                    </div>

                                    <div class="since">
                                        Follower since
                                        {{ $follow->created_at->format('M Y') }}
                                    </div>

                                </div>

                            </div>

                            <div class="menu-container">

                                <button class="menu-btn">
                                    ⋯
                                </button>

                                <div class="dropdown">

                                    <form method="POST" action="{{ route('follow', $follow->follower->id) }}">
                                        @csrf

                                        <button type="submit" style="color:red;">
                                            Unfriend
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <h3>No followers yet</h3>

            </div>

        @endif

    </div>

    <button id="scrollTopBtn" onclick="scrollToTop()">
        ↑
    </button>

    <script>

        window.onscroll = function () {

            const button =
                document.getElementById("scrollTopBtn");

            if (
                document.body.scrollTop > 300 ||
                document.documentElement.scrollTop > 300
            ) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };

        function scrollToTop() {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        }

    </script>

</body>

</html>