@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-green-700 py-4 text-2xl">My Notes</h1>
    <a href="/notes/create" class="underline text-blue-600 hover:text-blue-400">Create a new note</a>
</div>
<ul class="bg-white rounded shadow">
    <h3>Received Notes</h3>
    @foreach($receivedNotes as $note)
        <li class="border-b border-gray-200">
            <a href="/notes/{{ $note->id }}" class="p-4 w-full inline-block">{{ $note->title }}</a>
        </li>
    @endforeach

    <h3>Written Notes</h3>
    @foreach($writtenNotes as $note)
        <li class="border-b border-gray-200">
            <a href="/notes/{{ $note->id }}" class="p-4 w-full inline-block">{{ $note->title }}</a>
        </li>
    @endforeach
</ul>
@endsection
