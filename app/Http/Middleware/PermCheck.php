<?php

namespace tecai\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use tecai\Models\System\Account;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Token;

class PermCheck
{
    /**
     * @var JWTAuth
     */
    protected $auth;

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $this->auth->setRequest($request)->getToken();
        $payload = $this->auth->manager()->decode(new Token($token));

        $uri = $this->getResourceUri($request);
        $method = $request->getMethod();
        $account_id = $payload->get('id');

        if( ! Gate::forUser(Account::findOrFail($account_id))->check($uri, $method) ) {
            throw new AccessDeniedHttpException('无权限访问');
        }

        return $next($request);
    }

    /**
     * 获取资源的uri
     * @param \Illuminate\Http\Request $request
     * @return string $resourceUri
     */
    protected function getResourceUri($request) {
        $uri = $request->getPathInfo();
        $uri = trim($uri, '/');

        $segment = explode('/', $uri);

        if(count($segment) % 2 === 1) {//如果是奇数个，则是访问列表
            $resource = end($segment);
        } else {//否则就是访问指定某个资源
            end($segment);//id
            $resource = prev($segment) . '/{id}';
        }

        return '/' . $resource;
    }

}
