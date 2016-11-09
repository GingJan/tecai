<?php

namespace tecai\Providers;

use Illuminate\Support\ServiceProvider;
use tecai\Cache\Operations\OperationInterface;

class CacheOperationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tecai.cache', \tecai\Cache\Cache::class);
//        $this->app->singleton(\tecai\Cache\Policies\CachePolicyInterface::class, '');
        $this->registerOperations();
    }

    protected function registerOperations()
    {
        $structures = config('cache.structures');

        foreach ($structures as $structure => $concrete) {
            $this->app->singleton($structure, $concrete);
        }

    }
}
