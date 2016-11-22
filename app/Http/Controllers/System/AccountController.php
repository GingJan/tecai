<?php

namespace tecai\Http\Controllers\System;

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use tecai\Cache\Facades\Cache;
use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Transformers\AccountTransformer;

class AccountController extends Controller
{
    protected $repository;

    public function __construct(AccountRepository $accountRepository) {//注入仓库接口
        $this->repository = $accountRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->repository->paginate();
//        return $this->response()->paginator($this->repository->paginate(), new AccountTransformer());
    }

    public function login(Request $request) {
        $this->checkVerifyCode($request);

        $credentials = $request->only('account', 'password');
        $token = \JWTAuth::attempt($credentials);
        if (!$token)
            $this->invalidAttempt($request);

        $user = \Auth::getUser();

        //取出用户权限，存入redis
        $this->cachePermissions($user);

        $user->token = $token;
        return $this->response()->item($user, new AccountTransformer());
//        return $user;
    }

    /**
     * @param Request $request
     */
    protected function invalidAttempt($request)
    {
        try {
            Cache::sets('login:failed:ip')->add($request->getClientIp());//记录用户登录次数，第一次登录不需要验证码，密码错误后，第二次则需要
        } catch (\Exception $e) {
            \Log::notice($e->getFile() . '|' . $e->getLine() . $e->getMessage());
        }

        $this->response()->errorUnauthorized('invalid_credentials');
    }

    /**
     * @param Request $request
     */
    protected function checkVerifyCode($request)
    {
        $cache = false;
        try {
            $cache = Cache::sets('login:failed:ip')->has($request->getClientIp());
        } catch (\Exception $e) {
            \Log::notice($e->getFile() . '|' . $e->getLine() . $e->getMessage());
        }

        if ($cache) {
            //是否有Phrase头
            $phrase = $request->header('Phrase');
            if (is_null($phrase)) {
                $this->response()->errorBadRequest('verifyCode invalid');
            }

            //ip 有效期 是否正确
            list($payload, $encrypt) = explode('.', $phrase);
            $segment = json_decode(base64_decode($payload), true);
            if ($request->getClientIp() != $segment['ip'] || $_SERVER['REQUEST_TIME'] >= $segment['expire']) {
//                throw new BadRequestHttpException('verifyCode invalid', null, 40000);
                $this->response()->errorBadRequest('verifyCode invalid');
            }

            //判断验证码是否有效
            if (hash_hmac('sha256', $payload . $request->get('verifyCode'), config('jwt.secret')) != $encrypt) {
//                $this->invalidateVerifyCode($encrypt);
                $this->response()->errorBadRequest('verifyCode invalid');
            }
        }

    }

    protected function invalidateVerifyCode($code)
    {
        try {
            Cache::sets('blk:vc')->add($code);
        } catch (\Exception $e) {
            \Log::notice($e->getFile() . '|' . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * @param \tecai\Models\System\Account $user
     */
    protected function cachePermissions($user)
    {
        //取出用户权限，存入redis
        $roles = $user->roles->all();
        $allPermissions = [];
        foreach ($roles as $role) {
            $allPermissions = array_merge($allPermissions, $role->permissions->all());
        }

        $allPermissions = array_map(function ($permission) {
            return $permission->getKey();
        }, $allPermissions);

        try {
            Cache::sets('accounts:' . $user->getKey())->add($allPermissions);
        } catch (\Exception $e) {
            \Log::notice($e->getFile() . '|' . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->findModel($id, false, 'account');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(), $id);
        return $this->response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }
}
