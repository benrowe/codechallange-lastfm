<div class="row">
    <div class="col-sm-3"><img src="{{ $artist->image(\App\Services\LastFm\Response\Artist::IMAGE_SIZE_MEDIUM) }}" alt="{{ $artist->name }}"></div>
    <a href="/artist/{{ $artist->mbid }}">{{ $artist->name }}</a>
</div>