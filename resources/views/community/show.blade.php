<!DOCTYPE html>
<html>
<head>
    <title>{{ $community->name }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 16px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 18px;
            color: #3490dc;
            text-decoration: none;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .danger-btn {
            background: #dc3545;
        }

        .badge {
            background: #eee;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .private-badge {
            background: #ffe5e5;
            color: #c0392b;
        }

        .member-item {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .creator-badge {
            color: #3490dc;
            font-size: 12px;
            font-weight: bold;
        }

        .meta {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="/community" class="back-link">Back to Community List</a>

    @if ($errors->any())
        <div class="card" style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="card" style="color:green;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="card" style="color:red;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <h1>{{ $community->name }}</h1>

        @if($community->is_private)
            <span class="badge private-badge">
                Private Community
            </span>
        @endif

        <p>{{ $community->description }}</p>

        <p class="meta">
            Created by {{ $community->creator->username }} • {{ $community->created_at->diffForHumans() }}
        </p>

    </div>

    <div class="card">

        <h3>
            Members ({{ $community->members->count() }})
        </h3>

        @foreach($community->members as $member)

            <div class="member-item">

                {{ $member->username }}

                @if($member->id === $community->user_id)
                    <span class="creator-badge">
                        (Creator)
                    </span>
                @endif

            </div>

        @endforeach

    </div>

    <div class="card">

        @if(auth()->id() === $community->user_id)

            <button disabled>
                Creator
            </button>

        @elseif($community->members->contains(auth()->id()))

            <form method="POST" action="/community/{{ $community->id }}/leave">
                @csrf
                <button type="submit">
                    Leave Community
                </button>
            </form>

        @else

            <form method="POST" action="/community/{{ $community->id }}/join">
                @csrf
                <button type="submit">
                    Join Community
                </button>
            </form>

        @endif

    </div>

    @if(auth()->id() === $community->user_id)

        <div class="card">

            <h3>Edit Community</h3>

            <form method="POST" action="/community/{{ $community->id }}">
                @csrf
                @method('PUT')

                <input type="text" name="name" value="{{ $community->name }}" required>

                <textarea name="description" required>{{ $community->description }}</textarea>

                <label>
                    <input type="checkbox" name="is_private" value="1" {{ $community->is_private ? 'checked' : '' }}>
                    Private Community
                </label>

                <br><br>

                <button type="submit">
                    Update Community
                </button>

            </form>

        </div>

        <div class="card">

            <form method="POST" action="/community/{{ $community->id }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="danger-btn" onclick="return confirm('Yakin mau hapus community ini?')">
                    Delete Community
                </button>

            </form>

        </div>

    @endif

</div>

</body>
</html>