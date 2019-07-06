@extends('layouts.app')

@section('content')
<h1>Notes</h1>

<ul>
    @foreach($notes as $note)
        <li>{{ $note->title }}</li>
    @endforeach
</ul>
@endsection
