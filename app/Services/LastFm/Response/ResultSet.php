<?php

namespace App\Services\LastFm\Response;

use App\Services\LastFm\Client;

/**
 * Class ResultSet
 * Basic collection for the result set from lastfm calls (artists, tracks, etc)
 *
 * @package App\Services\LastFm\Response
 */
class ResultSet implements \App\Services\LastFm\Contracts\ResultSet
{
    private $data;
    private $client;

    public function __construct(array $data, Client $client)
    {
        $this->data = $data;
        $this->client = $client;
    }

    /**
     * Count the number within the result set
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @param $offset mixed
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param $offset mixed
     * @return AbstractResponse
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }
        return null;
    }

    /**
     * @param $offset mixed
     * @param $value AbstractResponse
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Remove an item from the result set
     *
     * @param $offset mixed
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }

    }
}
