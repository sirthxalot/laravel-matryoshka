<?php namespace Sirthxalot\Cache;

use Cache;

/**
 * Flush Views Middleware
 * ==============================================================================
 *
 * A middleware in order to handle cache specific requests, in order to flush the
 * view cache.
 *
 * @package   Sirthxalot\Cache
 * @author    Alexander Bösch - <sirthxalot.dev@gmail.com>
 * @copyright (c) 2016-2017, Alexander Bösch - All rights reserved.
 */
class FlushViews
{

    /**
     * Handle the Request
     * --------------------------------------------------------------------------
     *
     * Handles the caching requests, by flushing the cache of views using the
     * `@cache` directive and which are tagged. Than continue on by passing it
     * on the next request.
     *
     * @param \Illuminate\Http\Request $request
     * An object of the current request.
     *
     * @param \Closure $next
     * A closure function in order to pass the request on to the next request.
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        Cache::tags('views')->flush();

        return $next($request);
    }

}
