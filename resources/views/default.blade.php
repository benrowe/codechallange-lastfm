@extends('layouts.default')

@section('title', 'Top artists per country')

@section('content')
    @include('partials.form', ['model' => $model])
    @if ($results)
        <h1>Top Artists Per Country: {{ $model->country()->name }}</h1>
        <ol>
            @foreach ($results as $artist)
                <li>
                    @include('partials.artist', ['artist' => $artist])
                </li>
            @endforeach
        </ol>
        @include('partials.pagination', ['resultSet' => $results])
    @else
        Please select a country
    @endif
@endsection
