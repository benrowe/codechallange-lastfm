@extends('layouts.default')

@section('title', 'Top artists per country')

@section('content')
    @include('partials.form', ['model' => $model])
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
