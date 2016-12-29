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

    /**
     * AbstractModel constructor.
     * Initialise the concrete model with the supplied attributes
     *
     * @param null $attributes
     */
    public function __construct($attributes = null)
    {
        if (is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    /**
     * Fill the model with the array of attributes, in addition to any existing attribute values
     * Any existing values which matching keys will be overridden.
     *
     * @param array $attributes
     */
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
