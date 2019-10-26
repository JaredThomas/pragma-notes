@extends('layouts.app')

@section('content')
<div>
    {{ $note->title }}
</div>
<div>
    <a href="/notes/{{ $note->id }}/edit">Edit</a>
    <form action="/notes/{{ $note->id }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete note" />
    </form>
</div>
@endsection
