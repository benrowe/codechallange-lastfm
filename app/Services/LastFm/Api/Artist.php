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
use App\Services\LastFm\Response\Track;
use App\Services\LastFm\SearchRequest;
use App\Services\LastFm\Support\Musicbrainz;

/**
 * Artist API
 *
 * @package App\Services\LastFm\Api
 */
class Artist implements Searchable
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Artist constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Search last fm for artists based on the provided SearchRequest criteria
     *
     * @param SearchRequest $request
     * @param array         $params
     * @return ResultSet
     */
    public function search(SearchRequest $request, array $params = []): ResultSet
    {
        $params   = array_merge($params, $request->toArray());
        $response = $this->client->request(
            'artist.search',
            $params
        );

        return AbstractResponse::makeResultSet(
            $this->client,
            $response,
            ArtistResponse::class,
            'results.artistmatches.artist'
        );
    }

    /**
     * Find the artist by their id
     *
     * @param string $artistRef either the musicbrainz id or the artist name
     * @return AbstractResponse|bool false when no artist found
     * @throws Exception
     */
    public function find($artistRef)
    {
        $params = $this->buildArtistParams($artistRef);

        try {
            $response = $this->client->request('artist.getInfo', $params);
            return AbstractResponse::make(
                $this->client,
                $response,
                ArtistResponse::class,
                'artist'
            );
        } catch (Exception $e) {
            if ($e->getCode() == 6) {
                // artist not found
                return false;
            }
            throw $e;
        }
    }

    /**
     * Get top tracks for specified artist
     *
     * @param string $artistRef either the musicbrainz id or the artist name
     * @param array $params additional api params
     * @return \App\Services\LastFm\Response\ResultSet|bool
     * @throws Exception
     */
    public function topTracks($artistRef, array $params = [])
    {
        $params = $this->buildArtistParams($artistRef);
        $params = array_merge($params, $params);
        try {
            $response = $this->client->request(
                'artist.gettoptracks',
                $params
            );
        } catch (Exception $e) {
            if ($e->getCode() == 6) {
                return false;
            }
            throw $e;
        }

        return AbstractResponse::makeResultSet(
            $this->client,
            $response,
            Track::class,
            'toptracks.track'
        );
    }

    /**
     * Build the artist api params based on the type of data being provided
     *
     * @param string $artistRef
     * @return array
     */
    private function buildArtistParams($artistRef): array
    {
        if ((new Musicbrainz())->isValidId($artistRef)) {
            return ['mbid' => $artistRef];
        }

        return ['artist' => $artistRef];
    }
}
