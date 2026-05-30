<!DOCTYPE html>
<html>
<head>
    <title>{{ $community->name }}</title>
</head>
<body>

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

@if (session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<a href="/community">Back to Community List</a>

<h1>{{ $community->name }}</h1>

<p>{{ $community->description }}</p>

<small>
    Created by {{ $community->creator->username }} • {{ $community->created_at->diffForHumans() }}
    @if($community->is_private)
        · <strong>Private</strong>
    @endif
</small>

<hr>

<h3>Members ({{ $community->members->count() }})</h3>

@foreach($community->members as $member)
    <p>{{ $member->username }}</p>
@endforeach

<hr>

@if($community->members->contains(auth()->id()))

    <form method="POST" action="/community/{{ $community->id }}/leave">
        @csrf
        <button type="submit">Leave Community</button>
    </form>

@else

    <form method="POST" action="/community/{{ $community->id }}/join">
        @csrf
        <button type="submit">Join Community</button>
    </form>

@endif

@if(auth()->id() === $community->user_id)

    <hr>

    <h3>Edit Community</h3>

    <form method="POST" action="/community/{{ $community->id }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $community->name }}" required>
        <br>
        <textarea name="description" required>{{ $community->description }}</textarea>
        <br>
        <label>
            <input type="checkbox" name="is_private" value="1"
                {{ $community->is_private ? 'checked' : '' }}>
            Private Community
        </label>
        <br>
        <button type="submit">Update Community</button>
    </form>

    <hr>

    <form method="POST" action="/community/{{ $community->id }}">
        @csrf
        @method('DELETE')
        <button type="submit"
            onclick="return confirm('Yakin mau hapus community ini?')">
            Delete Community
        </button>
    </form>

@endif

</body>
</html>