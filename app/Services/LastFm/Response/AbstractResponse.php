<?php

namespace App\Services\LastFm\Response;

use App\Exceptions\InvalidParamException;
use App\Services\LastFm\Client;
use RuntimeException;

/**
 * Abstract Response
 *
 * Contains base functionality for Response models
 *
 * @package App\Services\LastFm\Response
 */
abstract class AbstractResponse
{
    //properties start
    /**
     * The raw data for the artist
     * @var array
     */
    protected $data;

    protected $client;
    //properties end

    public function __construct(array $data, Client $client)
    {
        $this->data = $data;
        $this->client = $client;
    }

    /**
     * Make an instance of the specified response type, based on the raw data, and the dot notation $key endpoint for
     * the raw data
     *
     * @param Client $client
     * @param array  $response raw response data
     * @param string $type     FQN of the response class to create
     * @param string $key      dot-notation key of where the root of the response data resides
     * @return AbstractResponse
     */
    public static function make(Client $client, array $response, $type, $key):AbstractResponse
    {
        self::verifyResponseType($type);

        return new $type(\App\array_get($response, $key), $client);
    }

    /**
     * @param Client $client
     * @param        $response
     * @param        $type
     * @param        $key
     * @return       ResultSet
     */
    public static function makeResultSet(Client $client, $response, $type, $key):ResultSet
    {
        self::verifyResponseType($type);
        $response = \App\array_get($response, $key);
        $data = [];
        foreach ($response as $item) {
            $data[] = new $type($item, $client);
        }
        return new ResultSet($data, $client);
    }

    /**
     * @param $type
     * @throws InvalidParamException
     */
    private static function verifyResponseType($type)
    {
        if (!is_subclass_of($type, self::class)) {
            throw new InvalidParamException(sprintf("Specified response object %s is not of %s", $type, self::class));
        }
    }

    /**
     * @param mixed $key
     * @return mixed
     * @throws RuntimeException
     */
    public function __get($key)
    {
        $methodName = 'get' . ucfirst($key);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        throw new RuntimeException(sprintf('%s does not have the property "%s"', get_class($this), $key));

    }
}
