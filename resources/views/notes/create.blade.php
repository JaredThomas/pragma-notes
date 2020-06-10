@extends('layouts.app')

@section('content')
<h1 class="text-green-700 py-4 text-2xl">Create a Note</h1>

<form action="/notes" method="POST" class="bg-white rounded p-4 shadow">
    @csrf
    <label for="recipient">Recipient</label>
    <select name="recipient">
        @foreach( $users as $user )
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <div>
        <label for="title" class="text-gray-800">Title</label>
        <input type="text" id="title" name="title" class="block mb-4 border p-2 border-gray-300 rounded w-full" required />
    </div>

    <div>
        <label for="body" class="text-gray-800">Note</label>
        <textarea name="body" id="body" class="block mb-4 border p-2 border-gray-300 rounded w-full h-64" required></textarea>
    </div>

    <input type="submit" value="Save my note" class="rounded px-8 py-2 bg-blue-500 text-white hover:bg-blue-400 cursor-pointer" />
</form>
@endsection
