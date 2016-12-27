<?php

namespace App\Models;

use App\Exceptions\InvalidParamException;

/**
 *
 * @package App\Models
 */
abstract class AbstractModel
{
    protected $attributes = [];

    public function __construct($attributes = null)
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    public function fill(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
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
     * Set the attribute
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}
