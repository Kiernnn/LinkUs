@extends('layouts.sidebar')
@section('title', 'Searched Posts')

@section('content')
    <div class="container">
        <h1>Search Results</h1>
            @if(count($results) > 0)
                <ul>
                    @foreach
                        <li>{{ $result->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>No results found.</p>
            @endif
    </div>
@endsection