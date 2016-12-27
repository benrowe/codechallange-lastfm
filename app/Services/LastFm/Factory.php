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
        $key = array_pull($config, 'api_key');
        $secret = array_pull($config, 'api_secret');

        return new Client($key, $secret, $config);
    }
}
