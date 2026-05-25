<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

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
        }

        .container {
            width: 600px;
            margin: 20px auto;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .logout-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Social Media</div>

    <form method="POST" action="/logout">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</div>

<div class="container">

    @if(session('success'))
        <div class="card" style="border: 1px solid #2ecc71; background: #ecf9f1; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <h3>Welcome, {{ auth()->user()->username }}</h3>
        <p>This is your dashboard</p>
    </div>

    <div class="card">
        <h3>Post a Tweet</h3>
        <form method="POST" action="/tweets">
            @csrf
            <div style="margin-bottom: 12px;">
                <label for="title">Title</label><br>
                <input id="title" name="title" type="text" value="{{ old('title') }}" style="width:100%; padding:8px; margin-top:4px;" />
                @error('title')
                    <div style="color:red; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 12px;">
                <label for="content">Content</label><br>
                <textarea id="content" name="content" rows="4" style="width:100%; padding:8px; margin-top:4px;">{{ old('content') }}</textarea>
                @error('content')
                    <div style="color:red; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="logout-btn" style="background:#3490dc;">Add Tweet</button>
        </form>
    </div>

    <div class="card">
        <h2>Your Tweets</h2>
        @if($tweets->isEmpty())
            <p>No tweets yet. Tambahkan tweet pertama kamu!</p>
        @else
            @foreach($tweets as $tweet)
                <div style="margin-bottom:15px; padding:12px; border:1px solid #ddd; border-radius:8px;">
                    <h4 style="margin:0 0 6px 0;">{{ $tweet->title }}</h4>
                    <p style="margin:0 0 8px 0;">{{ $tweet->content }}</p>
                    <small>By {{ $tweet->user?->username ?? 'Unknown' }} · {{ $tweet->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @endif
    </div>

</div>

</body>
</html>