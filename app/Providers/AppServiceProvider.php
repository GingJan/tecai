<?php

namespace tecai\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ExceptionHandler $handler)
    {
        //要在这里注册一个异常handler才可以处理异常
//        \DingoApi::error(function(\Exception $e) use($handler) {
//            $handler->render(app(\Illuminate\Http\Request::class), $e);
//        });
        \DingoApi::error(function(\Exception $e) {
            if( $e instanceof ModelNotFoundException) {
                //or throw new NotFoundHttpException;
                \DingoApi::response()->errorNotFound();
            } else {
                throw $e;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);//项目内自定义的SP

        //第三方包的SP，也可以在config/app下配置，但如果在config/app.php里配置，无论什么环境下都会载入该SP，虽然APP_DEBUG=false可以保证不会在正式环境上执行，但是依然会影响Laravel的启动速度和时间，也浪费内存，因为毕竟该SP会载入
//        if ( 'production' !== $this->app->environment() ) {//当为生产环境时才注册该服务提供者
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
//        }
//        if ( 'local' === $this->app->environment() ) {//只在本机（开发环境）下才注册
//            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
//        }
    }
}
