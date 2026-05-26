<h1>Community List</h1>

<form method="POST" action="/community">
    @csrf

    <input type="text" name="name" placeholder="Community Name">

    <textarea name="description"></textarea>

    <button type="submit">
        Create Community
    </button>
</form>

<hr>

@foreach($communities as $community)

    <h3>{{ $community->name }}</h3>

    <p>{{ $community->description }}</p>

    <small>
        Created by {{ $community->user->username }}
    </small>

@endforeach