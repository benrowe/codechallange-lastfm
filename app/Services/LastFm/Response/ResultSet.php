<?php

namespace App\Services\LastFm\Response;

use App\Services\LastFm\Client;
use App\Services\LastFm\Contracts\ResultSet as ResultSetContract;

/**
 * Class ResultSet
 * Basic collection for the result set from lastfm calls (artists, tracks, etc)
 *
 * @package App\Services\LastFm\Response
 */
class ResultSet implements ResultSetContract
{
    private $data;
    private $client;

    private $position = 0;

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

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *        Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
