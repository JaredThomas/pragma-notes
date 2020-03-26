@extends('layouts.app')

@section('content')
<div class="flex justify-end pt-4">
    <a href="/notes/{{ $note->id }}/edit" class="underline text-blue-600 hover:text-blue-400">Edit</a>
    <form action="/notes/{{ $note->id }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete note" />
    </form>
</div>

<div class="bg-white rounded p-4 shadow my-4">
    <div class="text-green-700 pb-4 text-2xl">
        {{ $note->title }}
    </div>
    <div>
        {!! nl2br(e($note->body)) !!}
    </div>
</div>
@endsection
