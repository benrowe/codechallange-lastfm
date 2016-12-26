<?php

namespace App\Models;

class Country
{
    const DATA_FILE = 'resources/data/countries.json';
    /**
     * Raw country data
     *
     * @todo move this into persistant data store
     * @todo provide full list of countries
     * @var array
     */
    private static $data;

    private $attributes = [];

    public function __construct($attributes = null)
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    /**
     * [__get description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        throw new \App\Exceptions\InvalidParamException(sprintf("Unknown property %s", $key));
    }

    public static function all()
    {
        $result = [];
        foreach (self::loadRawData() as $key => $country) {
            $result[$key] = new self($country);
        }
        return $result;
    }

    /**
     * [findById description]
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
