<?php

/**
 *
 */

namespace App\Services\LastFm;

use App\Support\LastFmClientCache;
use Doctrine\Common\Cache\CacheProvider;

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
     * Make an instance of the lastfm api client that supports request caching
     *
     * @param array         $config
     * @param CacheProvider $cache
     * @return Client
     */
    public static function fromConfigWithCaching(array $config, CacheProvider $cache): Client
    {
        $client = self::make(LastFmClientCache::class, $config);
        $client->setCacheProvider($cache);

        return $client;
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
