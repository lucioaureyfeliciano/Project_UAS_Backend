<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $community->name }}</title>

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
            width: 650px;
            margin: 25px auto;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .community-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .community-info h2 {
            margin: 0;
        }

        .community-total {
            color: #888;
            margin-top: 4px;
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-private {
            background: #fff3cd;
            color: #856404;
        }

        .badge-public {
            background: #d4edda;
            color: #155724;
        }

        .message {
            color: #333;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .meta {
            font-size: 12px;
            color: #999;
        }

        .member-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .creator-badge {
            background: #cce5ff;
            color: #004085;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
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

        .btn-primary {
            background: #3490dc;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-primary:hover {
            background: #2779bd;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-disabled {
            background: #ddd;
            color: #666;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #a3cfbb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f1aeb5;
        }

        h2, h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/community" class="back-btn">← Back</a>
    <strong>Community Detail</strong>
    <a href="/dashboard" class="back-btn">Dashboard</a>
</div>

<div class="container">

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert-success"> {{ session('success') }} </div>
    @endif

    @if (session('error'))
        <div class="alert-error"> {{ session('error') }} </div>
    @endif

    <div class="card">
        <div class="community-header">
            <div class="community-info">
                <h2>{{ $community->name }}</h2>
                <div class="community-total">{{ $community->members->count() }} members</div>

            </div>

            @if($community->is_private)
                <span class="badge badge-private">Private</span>
            @else
                <span class="badge badge-public">Public</span>
            @endif
        </div>

        <p class="message"> {{ $community->description }} </p>
        <div class="meta">Created by {{ $community->creator->username }} • {{ $community->created_at->diffForHumans() }}</div>

    </div>

    <div class="card">
        @if(auth()->id() === $community->user_id)
            <button class="btn-disabled" disabled>Creator</button>
        @elseif($community->members->contains(auth()->id()))

            <form method="POST" action="/community/{{ $community->id }}/leave">
                @csrf
                <button type="submit" class="btn-danger">Leave Community</button>
            </form>

        @elseif($community->is_private)

            <form method="POST" action="/community/{{ $community->id }}/request-join">
                @csrf
                <button type="submit" class="btn-primary">Request Join</button>
            </form>

        @else

            <form method="POST" action="/community/{{ $community->id }}/join">
                @csrf
                <button type="submit" class="btn-primary">Join Community</button>
            </form>

        @endif
    </div>

    <div class="card">
        <h3>Members</h3>

        @foreach($community->members as $member)

            <div class="member-card">
                <span>{{ $member->username }}</span>

                @if($member->id === $community->user_id)
                    <span class="creator-badge">Creator</span>
                @endif
            </div>

        @endforeach
    </div>

    @if(auth()->id() === $community->user_id)

        <div class="card">
            <h3>Pending Join Requests</h3>

            @php
                $pendingRequests = $community->joinRequests()->with('user')->where('status', 'pending')->get();
            @endphp

            @if($pendingRequests->isEmpty())
                <p>No pending requests.</p>
            @endif

            @foreach($pendingRequests as $request)

                <div class="member-card">
                    <span>{{ $request->user->username }}</span>

                    <div>
                        <form method="POST" action="/community/{{ $community->id }}/requests/{{ $request->id }}/approve" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-primary">Approve</button>
                        </form>

                        <form method="POST" action="/community/{{ $community->id }}/requests/{{ $request->id }}/reject" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-danger">Reject</button>
                        </form>
                    </div>

                </div>

            @endforeach
        </div>

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

                <button type="submit" class="btn-primary">Update Community</button>
            </form>
        </div>

        <div class="card">
            <form method="POST" action="/community/{{ $community->id }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-danger" onclick="return confirm('Yakin mau hapus community ini?')">
                    Delete Community
                </button>
            </form>
        </div>

    @endif
</div>

</body>
</html>
