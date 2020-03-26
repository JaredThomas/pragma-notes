@extends('layouts.app')

@section('content')
<h1 class="text-green-700 py-4 text-2xl">Edit Note</h1>

<form action="/notes/{{ $note->id }}" method="POST" class="bg-white rounded p-4 shadow">
    @csrf
    @method('PATCH')
    <div>
        <label for="title" class="text-gray-800">Title</label>
        <input type="text" name="title" id="title" class="block mb-4 border p-2 border-gray-300 rounded w-full" required value="{{ $note->title }}" />
    </div>

    <div>
        <label for="body" class="text-gray-800">Note</label>
        <textarea name="body" id="body" class="block mb-4 border p-2 border-gray-300 rounded w-full h-64" required>{{ $note->body }}</textarea>
    </div>

    <input type="submit" value="Update my note" class="rounded px-8 py-2 bg-blue-500 text-white hover:bg-blue-400 cursor-pointer" />
</form>
@endsection
