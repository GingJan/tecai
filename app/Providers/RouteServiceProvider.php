<?php

namespace tecai\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'tecai\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->requireDingoRoute();
        //'namespace'=>默认命名空间
//        $router->group(['namespace' => $this->namespace], function ($router) {
//            require app_path('Http/routes.php');//引入路由文件
//        });
    }

    public function requireDingoRoute() {
        $dgRoute = app('Dingo\Api\Routing\Router');//或者使用依赖注入

        $dgRoute->group([
            'version' => env('API_VERSION', 'v1'),
            'namespace' => $this->namespace,
        ], function($dgRoute) {
            require app_path('Http/routes.php');
        });
    }
}
