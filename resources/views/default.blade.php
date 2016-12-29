@extends('layouts.default')

@section('title', 'Top artists per country')

@section('content')
    @include('partials.form', ['model' => $model])
    @if ($results !== null)
        <h1>Top Artists Per Country: {{ $model->country()->name }}</h1>
        @if (count($results) > 0)
            <ul>
                @foreach ($results as $pos => $artist)
                    <li>
                        @include('partials.artist', ['artist' => $artist])
                    </li>
                @endforeach
            </ul>
            @include('partials.pagination', ['resultSet' => $results, 'url' => '?SearchForm%5Bcountry%5D='.$model->country.'&'])
        @else
            <p>No results can be found for {{ $model->country()->name }}</p>
        @endif
    @else
        Please select a country
    @endif
@endsection
