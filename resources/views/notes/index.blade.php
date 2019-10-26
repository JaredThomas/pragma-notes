@extends('layouts.app')

@section('content')
<h1>Notes</h1>
<div>
    <a href="/notes/create">Create a new note</a>
</div>
<ul>
    @foreach($notes as $note)
        <li>
            <a href="/notes/{{ $note->id }}">{{ $note->title }}</a>
        </li>
    @endforeach
</ul>
@endsection
