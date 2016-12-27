<?php

namespace App\Services\LastFm;

use App\Exceptions\InvalidParamException;
use App\Services\LastFm\Api\Artist;
use App\Services\LastFm\Api\Geo;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;

/**
 * LastFm API Client
 * Initial entry point for making requests to LastFM
 *
 * @package App\Services\LastFm
 * @property Artist $artist
 */
class Client
{
    const BASE_URL = 'http://ws.audioscrobbler.com/2.0/';
    const RESPONSE_FORMAT = 'json';
    const CLIENT_TIMEOUT = 5;

    //properties start
    private $apiKey;
    private $apiSecret;

    /**
     * @var ClientInterface
     */
    private $httpClient;
    //properties end

    /**
     * Client constructor.
     *
     * @param string $key
     * @param string $secret
     */
    public function __construct($key, $secret)
    {
        $this->apiKey    = $key;
        $this->apiSecret = $secret;
    }

    /**
     * Get the artist api
     *
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return new Artist($this);
    }

    public function getGeo(): Geo
    {
        return new Geo($this);
    }

    /**
     * Magic Method __get
     * Expose API classes as properties
     *
     * @param string $name
     * @return mixed
     * @throws InvalidParamException
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new InvalidParamException(sprintf('"%s" does not have the property "%s"', get_class($this), $method));
    }

    /**
     * Make a request to the api based
     *
     * @param string $methodName LastFM method see http://www.last.fm/api for details
     * @param array  $params     required + optional params
     * @return mixed
     * @throws Exception if invalid response
     */
    public function request($methodName, array $params = []): array
    {
        $params = $this->buildParams($methodName, $params);

        $client         = $this->getHttpClient();
        $clientResponse = $client->request('GET', '', ['query' => $params]);

        // check http response
        if ($clientResponse->getStatusCode() !== 200) {
            throw new Exception("LastFM invalid http response code");
        }

        $bodyDecode = json_decode($clientResponse->getBody(), true);

        // handle invalid/error responses
        if ($bodyDecode === null) {
            throw new Exception("The response from LastFM can not be decoded as valid JSON");
        }
        if (isset($bodyDecode['error'])) {
            throw new Exception(
                sprintf("LastFM error: %s (%s)", $bodyDecode['message'], $bodyDecode['error']),
                $bodyDecode['error']
            );
        }


        return $bodyDecode;
    }

    /**
     * Build up a standard set of parameters to send with the API request
     *
     * @param string $methodName the raw api method name
     * @param array  $params
     * @return array
     */
    private function buildParams($methodName, array $params = []): array
    {
        return array_merge([
            'method' => $methodName,
            'api_key' => $this->apiKey,
            'format' => self::RESPONSE_FORMAT,
        ], $params);
    }

    /**
     * Get the http client (guzzle)
     *
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        if (!$this->httpClient) {
            // establish new guzzle client
            $this->httpClient = new HttpClient([
                'base_uri' => self::BASE_URL,
                'timeout'  => self::CLIENT_TIMEOUT
            ]);
        }

        return $this->httpClient;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
