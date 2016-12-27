@extends('layouts.artist')

@section('title', $artist->name)

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <img src="{{$artist->image(\App\Services\LastFm\Response\Artist::IMAGE_SIZE_EXTRA_LARGE)}}" alt=""/>
        </div>
        <div class="col-sm-8">
            <h1>{{ $artist->name }}</h1>
            @include('partials.artist-tracks', ['tracks' => $artist->topTracks(), 'artist' => $artist])
        </div>
    </div>

@endsection
