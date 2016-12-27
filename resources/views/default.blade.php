@extends('layouts.default')

@section('content')
@if ($results)
    <h1>Top Artists Per Country: {{ $model->country()->name }}</h1>
    <ul>
        @foreach ($results as $artist)
            @include('partials.artist', ['artist' => $artist])
        @endforeach
    </ul>
    @include('partials.pagination', ['resultSet' => $results])
@else
    Please select a country
@endif
@endsection
