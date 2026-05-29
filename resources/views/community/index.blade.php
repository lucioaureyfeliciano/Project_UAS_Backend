<!DOCTYPE html>
<html>
<head>
    <title>Community List</title>
</head>
<body>

<div style="margin-bottom: 15px;">
    <a href="/dashboard">Back to Dashboard</a>
</div>

<h1>Community List</h1>

<form method="GET" action="/community">
    <input type="text" name="search" placeholder="Search community..." value="{{ $search ?? '' }}">

    <button type="submit">Search</button>

    @if(!empty($search))
        <a href="/community">Reset</a>
    @endif
</form>

<hr>

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

@if($communities->isEmpty())
    <p>No communities found.</p>
@endif

@foreach($communities as $community)

    <h3>
        <a href="/community/{{ $community->id }}">{{ $community->name }}</a>

        <small>
            ({{ $community->members->count() }} Members)
        </small>

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