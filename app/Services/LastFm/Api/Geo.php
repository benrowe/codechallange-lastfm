<?php

namespace App\Services\LastFm\Api;

use App\Services\LastFm\Client;
use App\Services\LastFm\Response\AbstractResponse;
use App\Services\LastFm\Response\Artist as ArtistResponse;

/**
 *
 * @package App\Services\LastFm
 */
class Geo
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the top artists per country
     *
     * @param  string $countryCode ISO 3166-1 country code
     * @return ResultSet
     */
    public function topArtists($countryCode)
    {
        $response = $this->client->request('geo.gettopartists', ['country' => $countryCode]);

        return AbstractResponse::makeResultSet($this->client, $response, ArtistResponse::class, 'topartists.artist');
    }
}
