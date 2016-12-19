<?php

namespace App\Models;

class Country
{
    /**
     * Raw country data
     *
     * @todo move this into persistant data store
     * @todo provide full list of countries
     * @var array
     */
    private static $data = [
        'au' => [
            'id' => 'au',
            'name' => 'Australia'
        ]
    ];

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
        foreach (self::$data as $key => $country) {
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
        if (isset(self::$data[$ref])) {
            return new self(self::$data[$ref]);
        }
        return null;
    }
}
