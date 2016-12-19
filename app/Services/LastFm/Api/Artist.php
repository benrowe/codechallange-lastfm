<?php

/**
 *
 */

namespace App\Services\LastFm\Api;

use App\Services\LastFm\Client;
use App\Services\LastFm\Contracts\ResultSet;
use App\Services\LastFm\Contracts\Searchable;
use App\Services\LastFm\Exception;
use App\Services\LastFm\Response\AbstractResponse;
use App\Services\LastFm\Response\Artist as ArtistResponse;
use App\Services\LastFm\SearchRequest;
use App\Services\LastFm\Support\Musicbrainz;

class Artist implements Searchable
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(SearchRequest $request): ResultSet
    {
        $response = $this->client->request('artist.search', $request->toArray());

        return AbstractResponse::makeResultSet($this->client, $response, ArtistResponse::class, 'results.artistmatches.artist');
    }

    /**
     * Find the artist by their id
     *
     * @param string $id either the musicbrainz id or the artist name
     * @return ArtistResponse|bool false when no artist found
     * @throws Exception
     */
    public function find($id)
    {
        if ((new Musicbrainz())->isValidId($id)) {
            $params = ['mbid' => $id];
        } else {
            $params = ['artist' => $id];
        }

        try {
            $response = $this->client->request('artist.getInfo', $params);
            return AbstractResponse::make($this->client, $response, ArtistResponse::class, 'artist');
        } catch (Exception $e) {
            if ($e->getCode() == 6) {
                // artist not found
                return false;
            }
            throw $e;
        }
    }
}