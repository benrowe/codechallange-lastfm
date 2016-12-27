<h2>Top Tracks for {{ $artist->name }}</h2>
<ol>
    @foreach($tracks as $track)
        <li><a href="{{ $track->url }}">{{ $track->name }}</a></li>
    @endforeach
</ol>