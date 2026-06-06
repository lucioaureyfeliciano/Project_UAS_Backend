<!DOCTYPE html>
<html>
<head>
    <title>Community List</title>

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

        .community-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .community-card.private {
            background: #fffaf0;
            border-left: 4px solid #f39c12;
        }

        .community-card.public {
            border-left: 4px solid #3490dc;
        }

        .community-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #eaf4ff;
            color: #3490dc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .community-body {
            flex: 1;
        }

        .community-title {
            margin: 0 0 5px 0;
        }

        .community-title a {
            color: #333;
            text-decoration: none;
        }

        .community-title a:hover {
            color: #3490dc;
            text-decoration: underline;
        }

        .community-message {
            color: #333;
            line-height: 1.5;
            margin-bottom: 6px;
        }

        .community-time {
            font-size: 12px;
            color: #999;
        }

        .community-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .badge-public {
            background: #d4edda;
            color: #155724;
        }

        .badge-private {
            background: #fff3cd;
            color: #856404;
        }

        .badge-creator {
            background: #cce5ff;
            color: #004085;
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
            font-size: 13px;
        }

        button:hover {
            background: #2779bd;
        }

        button:disabled {
            background: #ddd;
            color: #666;
            cursor: not-allowed;
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

        .reset-link {
            color: #3490dc;
            text-decoration: none;
            margin-left: 8px;
        }

        .empty-state {
            color: #888;
            text-align: center;
        }

        h1, h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Back</a>
    <strong>Community List</strong>
    <span></span>
</div>

<div class="container">
    <div class="card">
        <h2>Search Community</h2>

        <form method="GET" action="/community">
            <input type="text" name="search" placeholder="Search community..." value="{{ $search ?? '' }}">
            <button type="submit">Search</button>

            @if(!empty($search))
                <a href="/community" class="reset-link">Reset</a>
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

    @if($communities->isEmpty())
        <div class="card empty-state">
            <p>Community tidak ditemukan.</p>
        </div>
    @endif

    @foreach($communities as $community)
        <div class="community-card {{ $community->is_private ? 'private' : 'public' }}">

            <div class="community-icon"> 👥 </div>

            <div class="community-body">

                @if($community->is_private)
                    <span class="badge badge-private">Private</span>
                @else
                    <span class="badge badge-public">Public</span>
                @endif

                <h3 class="community-title">
                    <a href="/community/{{ $community->id }}">{{ $community->name }}</a>
                </h3>
                <div class="community-message"> {{ $community->description }} </div>

                <div class="community-time">
                    {{ $community->members->count() }} Members 
                    • Created by {{ $community->creator->username }} 
                    • {{ $community->created_at->diffForHumans() }}
                </div>

            </div>

            <div class="community-actions">
                @if(auth()->id() === $community->user_id)
                    <span class="badge badge-creator">Creator</span>
                @elseif($community->is_private)

                    <form method="POST" action="/community/{{ $community->id }}/request-join">
                        @csrf
                        <button type="submit">Request Join</button>
                    </form>

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

        </div>

    @endforeach
</div>

</body>
</html>
