<?php namespace Sirthxalot\Cache;

/**
 * Cacheable Trait
 * ==============================================================================
 *
 * The Cacheable trait allows to provide all methods in order to confirm the
 * contract (interface) for cachable models. This trait should be used within
 * all classes that should be cacheable.
 *
 * @package   Sirthxalot\Cache
 * @author    Alexander Bösch - <sirthxalot.dev@gmail.com>
 * @copyright (c) 2016-2017, Alexander Bösch - All rights reserved.
 */
trait Cacheable
{

    /**
     * Get Cache Key
     * --------------------------------------------------------------------------
     *
     * Calculate a unique cache key for the model instance.
     *
     * @return string
     * A calculated unique cache key for the model instance as a string.
     */
    public function getCacheKey()
    {
        return sprintf("%s/%s-%s", get_class($this), $this->getKey(), $this->updated_at->timestamp);
    }

}
