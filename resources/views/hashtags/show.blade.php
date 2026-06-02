<!DOCTYPE html>
<html>
<head>
    <title>#{{ $hashtag->name }}</title>
</head>
<body>

<h1>#{{ $hashtag->name }}</h1>

@foreach($tweets as $tweet)

    <div style="border:1px solid #ddd;padding:15px;margin:10px;">

        <h3>{{ $tweet->title }}</h3>

        <p>{{ $tweet->content }}</p>

        <small>
            {{ $tweet->user->username }}
        </small>

    </div>

@endforeach

</body>
</html>