<h2>Top Tracks for {{ $artist->name }}</h2>
<ul>
    @foreach($tracks as $track)
        <li><a href="{{ $track->url }}">{{ $track->name }}</a></li>
    @endforeach
</ul>