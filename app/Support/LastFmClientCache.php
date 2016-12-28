<?php

namespace App\Support;

use App\Exceptions\RuntimeException;
use App\Services\LastFm\Client;
use Doctrine\Common\Cache\CacheProvider;

/**
 * LastFmClientCache
 *
 * Simple caching extension to the last fm api
 * Enables requests to lastfm to be cached for performance
 *
 * @package App\Support
 */
class LastFmClientCache extends Client
{
    const CACHE_KEY_PREFIX = 'services.lastfm.';
    const CACHE_TTL_DEFAULT = 3600;

    /**
     * @var CacheProvider
     */
    private $cache;


    /**
     * {@inheritdoc}
     */
    public function request($methodName, array $params = []): array
    {
        $key = $this->makeCacheKey($methodName, $params);
        $value = $this->getCacheProvider()->fetch($key);
        if ($value === false) {
            $value = parent::request($methodName, $params);
            $this->getCacheProvider()->save($key, $value, self::CACHE_TTL_DEFAULT);
        }
        return $value;
    }

    /**
     * Set the instance of the cache provider to use
     *
     * @param CacheProvider $provider
     */
    public function setCacheProvider(CacheProvider $provider)
    {
        $this->cache = $provider;
    }

    /**
     * Retrieve the instance of the cache provider
     *
     * @return CacheProvider
     * @throws RuntimeException
     */
    public function getCacheProvider(): CacheProvider
    {
        if (!$this->cache) {
            throw new RuntimeException(sprintf("No cache has been provided to %s", get_class($this)));
        }
        return $this->cache;
    }

    /**
     * Create a unique string to represent the state of the api request
     *
     * @param string $methodName
     * @param array $params
     * @return string
     */
    private function makeCacheKey($methodName, array $params): string
    {
        return self::CACHE_KEY_PREFIX . md5(serialize([$methodName, $params]));
    }

}
