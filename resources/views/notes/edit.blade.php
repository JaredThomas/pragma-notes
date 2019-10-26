@extends('layouts.app')

@section('content')
<h1>Edit {{ $note->title }}</h1>

<form action="/notes/{{ $note->id }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required value="{{ $note->title }}" />
    </div>

    <div>
        <label for="body">Note</label>
        <textarea name="body" id="body" required>{{ $note->body }}</textarea>
    </div>

    <input type="submit" value="Update my note" />
</form>
@endsection
