@extends('layouts.app')

@section('content')
<div class="flex justify-end pt-4">
    @can('update', $note)
    <a href="/notes/{{ $note->id }}/edit" class="underline text-blue-600 hover:text-blue-400">Edit</a>
    @endcan
    @can('delete', $note)
    <form action="/notes/{{ $note->id }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete note" />
    </form>
    @endcan
</div>

<div class="bg-white rounded p-4 shadow my-4">
    @if ( $note->author->id !== auth()->user()->id )
        <p>From: {{ $note->author->name }}</p>
    @endif
    <div class="text-green-700 pb-4 text-2xl">
        {{ $note->title }}
    </div>
    <div>
        {!! nl2br(e($note->body)) !!}
    </div>
</div>
@endsection
