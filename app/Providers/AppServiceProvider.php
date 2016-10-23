<?php

namespace tecai\Providers;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use tecai\Criteria\BaseCriteria;

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
//            var_dump($e instanceof ModelNotFoundException);
            if( $e instanceof \ErrorException) {
//                //log;

//                \DingoApi::response()->errorInternal($e->getMessage());
            }
            else if( $e instanceof ModelNotFoundException ) {
//                throw new ResourceException($e->getMessage(), null, $e); //422
                \DingoApi::response()->errorNotFound();
//                return 'f';
            }
//            else if ( $e instanceof HttpException) {
//                throw $e;
//            }
            else if ( $e instanceof ValidatorException) {
                \DingoApi::response()->errorBadRequest($e->getMessageBag());
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
        $this->app->singleton(CriteriaInterface::class, config('repository.criteria.baseCriteria', BaseCriteria::class));
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
