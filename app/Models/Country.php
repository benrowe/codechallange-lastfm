<?php

namespace App\Models;

use App\Exceptions\InvalidParamException;

class Country
{
    /**
     * Raw country data
     *
     * @todo move this into persistent data store
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
        foreach (self::$data as $key => $country) {
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
        if (isset(self::$data[$ref])) {
            return new self(self::$data[$ref]);
        }
        return null;
    }
}
