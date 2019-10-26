@extends('layouts.app')

@section('content')
<h1>Create a Note</h1>

<form action="/notes" method="POST">
    @csrf
    <div>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required />
    </div>

    <div>
        <label for="body">Note</label>
        <textarea name="body" id="body" required></textarea>
    </div>

    <input type="submit" value="Save my note" />
</form>
@endsection
