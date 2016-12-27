@extends('layouts.artist')

@section('content')
    <img src="{{$artist->image(\App\Services\LastFm\Response\Artist::IMAGE_SIZE_EXTRA_LARGE)}}" alt=""/>
    {{$artist->name}}
    @include('partials.artist-tracks', ['tracks' => $artist->topTracks()])
@endsection
