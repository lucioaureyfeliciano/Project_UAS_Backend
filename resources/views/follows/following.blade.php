<!DOCTYPE html>
<html>

<head>
    <title>Following</title>

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

    <h1 class="section-title">Following</h1>

    @forelse($user->following as $follow)

        <div style="
                                        padding:15px;
                                        margin-bottom:10px;
                                        border:1px solid #444;
                                        border-radius:10px;
                                        background: #b4cde5;
                                    ">

            <a href="/profile/{{ $follow->following->username }}">
                <h3>
                    👤 {{ $follow->following->username }}
                </h3>
            </a>

        </div>

    @empty

        <p>No following yet.</p>

    @endforelse

</body>

</html>