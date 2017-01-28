<?php namespace Sirthxalot\Cache;

use Exception;

/**
 * Blade Directive
 * ==============================================================================
 *
 * Handles the Russian-Doll Caching for Laravel's Blade directives. It contains
 * the all the magic (logic) used to provide a fully Russian-Doll caching system
 * ready to use out of box.
 *
 * @package   Sirthxalot\Cache
 * @author    Alexander Bösch - <sirthxalot.dev@gmail.com>
 * @copyright (c) 2016-2017, Alexander Bösch - All rights reserved.
 */
class BladeDirective
{

    /**
     * Cache Instance
     * --------------------------------------------------------------------------
     *
     * @var RussianCaching
     * Determine the `RussianCaching` instance.
     */
    protected $cache;


    /**
     * Model Cache Keys
     * --------------------------------------------------------------------------
     *
     * @param array $keys
     * Determine an array of model cache keys.
     */
    protected $keys = [];


    /**
     * Construct new blade directive
     * --------------------------------------------------------------------------
     *
     * @param RussianCaching $cache
     * A `RussianCaching` object instance.
     */
    public function __construct(RussianCaching $cache)
    {
        $this->cache = $cache;
    }


    /**
     * Setup Blade Directive
     * --------------------------------------------------------------------------
     *
     * Handle the `@cache` directive setup. It turns on output buffering and returns
     * a boolean which determines, if we need to proceed the code or if we could take
     * it from the cache instead.
     *
     * @param mixed $model
     * An instance of the model that should be cached.
     *
     * @param string|null $key
     * A string that determines the caching key.
     *
     * @return boolean
     * A boolean which determines if the model has been cached yet.
     */
    public function setUp($model, $key = null)
    {
        ob_start();

        $this->keys[] = $key = $this->normalizeKey($model, $key);

        return $this->cache->has($key);
    }


    /**
     * Tear Down Blade Directive
     * --------------------------------------------------------------------------
     *
     * Handle the `@endcache` teardown. It fetches the caching key, save the output
     * buffer contents to a variable called `$html`. Cache it, if necessary and
     * echo out the HTML.
     *
     * @return mixed
     */
    public function tearDown()
    {
        return $this->cache->put(array_pop($this->keys), ob_get_clean());
    }


    /**
     * Normalize the Cache Key
     * --------------------------------------------------------------------------
     *
     * Normalize the cache key for custom cache keys (`string`), models (`object`)
     * or collections (`\Illuminate\Support\Collection`), otherwise it will throw
     * an exception.
     *
     * @param mixed       $item
     * A string, object or collection to find caching key.
     *
     * @param string|null $key
     * Custom caching key to override default.
     *
     * @return string
     * A string that determines the caching key.
     *
     * @throws Exception
     * Could not determine an appropriate cache key.
     */
    protected function normalizeKey($item, $key = null)
    {
        // if the user wants to provide their own cache
        // key, we'll opt for that.
        if (is_string($item) || is_string($key)) {
            return is_string($item) ? $item : $key;
        }

        // otherwise we'll try to use the item to calculate
        // the cache key, itself.
        if (is_object($item) && method_exists($item, 'getCacheKey')) {
            return $item->getCacheKey();
        }

        // if we're dealing with a collection, we'll
        // use a hashed version of its contents.
        if ($item instanceof \Illuminate\Support\Collection) {
            return md5($item);
        }

        throw new Exception('Could not determine an appropriate cache key.');
    }

}
