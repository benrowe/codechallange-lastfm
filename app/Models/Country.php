<?php

namespace App\Models;

use App\Exceptions\InvalidParamException;

/**
 * Country
 *
 * @package App\Models
 */
class Country
{
    const DATA_FILE = 'resources/data/countries.json';

    /**
     * Raw country data
     *
     * @todo move this into persistent data store
     * @todo provide full list of countries
     * @var array
     */
    private static $data;

    private $attributes = [];

    /**
     * Country constructor.
     *
     * @param null|array $attributes
     */
    public function __construct($attributes = null)
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    /**
     * Access attributes as properties
     *
     * @param  string $key
     * @return mixed
     * @throws InvalidParamException
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        throw new InvalidParamException(sprintf("Unknown property %s", $key));
    }

    /**
     * @return Country[]
     */
    public static function all()
    {
        $result = [];
        foreach (self::loadRawData() as $key => $country) {
            $result[$key] = new self($country);
        }
        return $result;
    }

    /**
     * Find a specific country by its ISO id
     *
     * @param  string $ref country identifier
     * @return Country|null
     */
    public static function findById($ref)
    {
        $data = self::loadRawData();
        $ref = strtoupper($ref);
        if (isset($data[$ref])) {
            return new self($data[$ref]);
        }
        return null;
    }

    /**
     * Load and return the raw country data
     */
    private static function loadRawData()
    {
        if (!is_array(self::$data)) {
            $path = \App\path(self::DATA_FILE);
            $content = file_get_contents($path);
            self::$data = json_decode($content, true);
        }
        return self::$data;
    }
}
