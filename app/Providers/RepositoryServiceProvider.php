<?php

namespace tecai\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->singleton('tecai\Repositories\Interfaces\System\PermissionRepository', 'tecai\Repositories\System\PermissionRepositoryEloquent');
        $this->app->singleton('tecai\Repositories\Interfaces\System\RoleRepository', 'tecai\Repositories\System\RoleRepositoryEloquent');
        $this->app->singleton('tecai\Repositories\Interfaces\System\AdminRepository', 'tecai\Repositories\System\AdminRepositoryEloquent');
    }
}
