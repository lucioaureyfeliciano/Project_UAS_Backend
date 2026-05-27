<!DOCTYPE html>
<html>
<head>
    <title>Community List</title>
</head>
<body>

<h1>Community List</h1>

<form method="POST" action="/community">
    @csrf

    <input type="text" name="name" placeholder="Community Name" required>
    <br>
    <textarea name="description" placeholder="Description" required></textarea>
    <br>
    <label>
        <input type="checkbox" name="is_private" value="1">
        Private Community
    </label>
    <br>
    <button type="submit">Create Community</button>

</form>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<hr>

@foreach($communities as $community)

    <h3>
        <a href="/community/{{ $community->id }}">{{ $community->name }}</a>
        @if($community->is_private)
            <small>(Private)</small>
        @endif
    </h3>

    <p>{{ $community->description }}</p>

    <small>Created by {{ $community->creator->username }}</small>

    <br>

    <form method="POST" action="/community/{{ $community->id }}/join">
        @csrf
        <button type="submit">Join</button>
    </form>

    <hr>

@endforeach

</body>
</html>