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
 * @property Artist artist
 * @property Geo    geo
 * @todo    create unique Exception class for these errors
 */
class Client
{
    const BASE_URL = 'http://ws.audioscrobbler.com/2.0/';
    const RESPONSE_FORMAT = 'json';
    const CLIENT_TIMEOUT = 5;

    //properties start
    private $apiKey;
    private $apiSecret;
    private $apiOptions = [];

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
     * @param array  $options
     */
    public function __construct($key, $secret, array $options = [])
    {
        $this->apiKey     = $key;
        $this->apiSecret  = $secret;
        $this->apiOptions = $options;
    }

    /**
     * Get the api key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the api secret
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->apiOptions;
    }

    /**
     * Get the custom option ba
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        $value = \App\array_get($this->apiOptions, $key);
        if ($value) {
            return $value;
        }
        return $default;
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

    /**
     * Get the geo api
     *
     * @return Geo
     */
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
            'method'  => $methodName,
            'api_key' => $this->apiKey,
            'format'  => self::RESPONSE_FORMAT,
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
     * Inject the required http client
     *
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
