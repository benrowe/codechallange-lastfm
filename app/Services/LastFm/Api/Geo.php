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
    use TraitSupportsPagintation;
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
     * @param array   $params additional params for the api request
     * @return ResultSet
     */
    public function topArtists($countryCode, array $params = [])
    {
        $params = array_merge($params, ['country' => $countryCode]);
        return $this->buildPaginationResultSet(
            'geo.gettopartists',
            $params,
            ArtistResponse::class,
            'topartists.artist'
        );
    }
}
