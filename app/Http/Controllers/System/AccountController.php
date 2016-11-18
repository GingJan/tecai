<?php

namespace tecai\Http\Controllers\System;

use Illuminate\Http\Request;

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
        $credentials = $request->only('account', 'password');
        $token = \JWTAuth::attempt($credentials);
        if (!$token) {
            $this->response()->errorUnauthorized('invalid_credentials');
        }
        $user = \Auth::getUser();
        $user->token = $token;
        //取出数据，存入redis/memcached
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
            //log it
        }
//        return $this->response()->item($user, new AccountTransformer());
        return $user;
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
