<?php namespace Sirthxalot\Cache;

use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Russian-Doll Caching
 * ==============================================================================
 *
 * Russian Doll caching is an interesting approach, where you create nested fragment
 * caches for your view logic. If you then link the keys for each of these cached items
 * to the model's "updated at" timestamp, what you get is easy caching for your view
 * logic, and automatic cache busting whenever the model is updated.
 *
 * @package   Sirthxalot\Cache
 * @author    Alexander Bösch - <sirthxalot.dev@gmail.com>
 * @copyright (c) 2016-2017, Alexander Bösch - All rights reserved.
 */
class RussianCaching
{

    /**
     * Cache Repository
     * --------------------------------------------------------------------------
     *
     * @var Cache
     * Determine a cache repository instance.
     */
    protected $cache;


    /**
     * Construct new class instance
     * --------------------------------------------------------------------------
     *
     * @param Cache $cache
     * An instance of Cache.
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }


    /**
     * Put to the Cache
     * --------------------------------------------------------------------------
     *
     * Determine the cache key by calling the `normalizeCacheKey()` method and
     * return a cache fragment tagged with `views`, which will be remembered
     * forever.
     *
     * @param mixed  $key
     * @param string $fragment
     * @return mixed
     */
    public function put($key, $fragment)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache->tags('views')->rememberForever($key, function () use ($fragment) {
            return $fragment;
        });
    }


    /**
     * Has Cache Key
     * --------------------------------------------------------------------------
     *
     * Check if the given key exists in the cache.
     *
     * @param mixed $key
     *
     * @return boolean
     * A boolean that determine if the key has been cached yet.
     */
    public function has($key)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache->tags('views')->has($key);
    }


    /**
     * Normalize the Cache Key
     * --------------------------------------------------------------------------
     *
     * @param mixed $key
     * @return mixed
     */
    protected function normalizeCacheKey($key)
    {
        if (is_object($key) && method_exists($key, 'getCacheKey')) {
            return $key->getCacheKey();
        }

        return $key;
    }

}
