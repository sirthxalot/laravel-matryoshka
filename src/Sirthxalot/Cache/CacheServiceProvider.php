<?php namespace Sirthxalot\Cache;

use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

/**
 * Cache Service Provider
 * ==============================================================================
 *
 * The `CacheServiceProvider` class will register and bootstrap any services
 * needed for Russian-Doll caching into your Laravel application. All you need to
 * do is to bind this service provider into your IOC and you are done.
 *
 * @package   Sirthxalot\Cache
 * @author    Alexander Bösch - <sirthxalot.dev@gmail.com>
 * @copyright (c) 2016-2017, Alexander Bösch - All rights reserved.
 */
class CacheServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap Services
     * --------------------------------------------------------------------------
     *
     * This method is called after all other service providers have been registered,
     * meaning, you have access to all other services that have been registered by
     * the framework. So lets begin to boot up Russian-Doll caching.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        if ($this->app->isLocal()) {
            $kernel->pushMiddleware('Sirthxalot\Cache\FlushViews');
        }

        Blade::directive('cache', function ($expression) {
            return "<?php if (! app('Sirthxalot\Cache\BladeDirective')->setUp({$expression})) : ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php endif; echo app('Sirthxalot\Cache\BladeDirective')->tearDown() ?>";
        });
    }


    /**
     * Register Services
     * --------------------------------------------------------------------------
     *
     * Helps to register services to into the service container. But you should
     * never attempt to register any event listeners, routes, or any other piece
     * of functionality within this method.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BladeDirective::class);
    }

}
