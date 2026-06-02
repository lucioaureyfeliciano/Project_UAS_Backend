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

        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h1 class="section-title">Followers</h1>

    @forelse($user->followers as $follow)

        <div style="
                                        padding:15px;
                                        margin-bottom:10px;
                                        border:1px solid #444;
                                        border-radius:10px;
                                        background: #b4cde5;
                                    ">

            <a href="/profile/{{ $follow->follower->username }}">
                <h3>
                    👤 {{ $follow->follower->username }}
                </h3>
            </a>

        </div>

    @empty

        <p>No followers yet.</p>

    @endforelse

</body>

</html>