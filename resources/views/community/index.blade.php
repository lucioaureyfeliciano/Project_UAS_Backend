<!DOCTYPE html>
<html>
<head>
    <title>Community List</title>

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

        .top-link {
            display: inline-block;
            margin-bottom: 18px;
            color: #3490dc;
            text-decoration: none;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:disabled {
            background: #ccc;
            cursor: not-allowed;
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

        .meta {
            color: #666;
            font-size: 14px;
        }

        .community-title a {
            color: #222;
            text-decoration: none;
        }

        .community-title a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="/dashboard" class="top-link">Back to Dashboard</a>

    <div class="card">
        <h1>Community List</h1>

        <form method="GET" action="/community">
            <input type="text" name="search" placeholder="Search community..." value="{{ $search ?? '' }}">
            <button type="submit">Search</button>

            @if(!empty($search))
                <a href="/community">Reset</a>
            @endif
        </form>
    </div>

    <div class="card">
        <h2>Create Community</h2>

        <form method="POST" action="/community">
            @csrf

            <input type="text" name="name" placeholder="Community Name" required>

            <textarea name="description" placeholder="Description" required></textarea>

            <label>
                <input type="checkbox" name="is_private" value="1" style="width:auto;">
                Private Community
            </label>

            <br><br>

            <button type="submit">Create Community</button>
        </form>
    </div>

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

    @if($communities->isEmpty())
        <div class="card">
            <p>Community tidak ditemukan.</p>
        </div>
    @endif

    @foreach($communities as $community)

        <div class="card">

            <h3 class="community-title">
                <a href="/community/{{ $community->id }}">{{ $community->name }}</a>

                <span class="badge">
                    {{ $community->members->count() }} Members
                </span>

                @if($community->is_private)
                    <span class="badge private-badge">Private</span>
                @endif
            </h3>

            <p>{{ $community->description }}</p>

            <p class="meta">
                Created by {{ $community->creator->username }} • {{ $community->created_at->diffForHumans() }}
            </p>

            @if(auth()->id() === $community->user_id)

                <button disabled>Creator</button>

            @elseif($community->is_private)

                <button disabled>Private Community</button>

            @elseif($community->members->contains(auth()->id()))

                <form method="POST" action="/community/{{ $community->id }}/leave">
                    @csrf
                    <button type="submit">Leave</button>
                </form>

            @else

                <form method="POST" action="/community/{{ $community->id }}/join">
                    @csrf
                    <button type="submit">Join</button>
                </form>

            @endif

        </div>

    @endforeach

</div>

</body>
</html>