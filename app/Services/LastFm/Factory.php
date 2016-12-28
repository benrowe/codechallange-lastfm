<?php

/**
 *
 */

namespace App\Services\LastFm;

class Factory
{
    /**
     * Create a new instance of the LastFm client based on the lastfm configuration file
     *
     * @param array $config
     * @return Client
     */
    public static function fromConfig(array $config): Client
    {
        return self::make(Client::class, $config);
    }

    /**
     * Make an instance of the lastfm client, using the specified type and configuration values
     * @param $class
     * @param $config
     * @return mixed
     */
    private static function make($class, $config)
    {
        $key = array_pull($config, 'api_key');
        $secret = array_pull($config, 'api_secret');

        return new $class($key, $secret, $config);
    }
}
