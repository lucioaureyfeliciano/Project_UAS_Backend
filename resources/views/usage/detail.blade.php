<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

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

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            width: 700px;
            margin: 25px auto;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .meta {
            color: #777;
            font-size: 13px;
            margin-top: 6px;
        }

        .empty-state {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            text-align: center;
            color: #777;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 6px;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d4edda;
            color: #155724;
        }

        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/usage">← Back</a>
    <strong>{{ $title }}</strong>
    <span></span>
</div>

<div class="container">

    @if($items->isEmpty())
        <div class="empty-state">
            No data found.
        </div>
    @endif

    @foreach($items as $item)
        <div class="card">

            @if($title == 'All Users')

                <strong>{{ $item->username }}</strong>

                <div class="meta">
                    Email: {{ $item->email }}
                </div>

            @elseif($title == 'All Tweets')

                <strong>{{ $item->title }}</strong>
                <p>{{ $item->content }}</p>
                <div class="meta">
                    User: {{ $item->user->username }}
                </div>

            @elseif($title == 'All Communities')

                <strong>{{ $item->name }}</strong>
                <p>{{ $item->description }}</p>
                <div class="meta">
                    Creator: {{ $item->creator->username }}
                </div>

            @elseif($title == 'Community Activities')

                <strong>{{ $item->user->username }}</strong>

                @if($item->action == 'created')
                    <span class="badge badge-approved">created</span>
                @elseif($item->action == 'updated')
                    <span class="badge badge-pending">updated</span>
                @elseif($item->action == 'joined')
                    <span class="badge badge-approved">joined</span>
                @elseif($item->action == 'left')
                    <span class="badge badge-rejected">left</span>
                @elseif($item->action == 'requested_join')
                    <span class="badge badge-pending">requested to join</span>
                @elseif($item->action == 'approved_request')
                    <span class="badge badge-approved">was approved to join</span>
                @elseif($item->action == 'rejected_request')
                    <span class="badge badge-rejected">was rejected from</span>
                @endif

                community

                <strong style="color: #3490dc;">
                    {{ $item->community->name }}
                </strong>

                <div class="meta">
                    {{ $item->created_at->diffForHumans() }}
                </div>

            @elseif($title == 'Follow Activities')

                <strong>{{ $item->follower->username }}</strong>
                followed
                <strong>{{ $item->following->username }}</strong>
                <div class="meta">
                    {{ $item->created_at->diffForHumans() }}
                </div>

            @else

                <pre>{{ print_r($item->toArray(), true) }}</pre>

            @endif

        </div>
    @endforeach

</div>

</body>
</html>
