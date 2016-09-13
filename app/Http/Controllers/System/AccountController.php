<?php

namespace tecai\Http\Controllers\System;

use Illuminate\Http\Request;

use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Model\System\Admin;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Repositories\Interfaces\System\AdminRepository;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        try {
            $res = $this->repository->listByLimit($request->getQuery());

            return $res;
//            return $this->response()->collection($res, new StaffTransformer());
//            } catch(QueryException $e) {
                //可以加个log日志记录
//                $this->response()->errorNotFound();
//            }
//            return $this->repository->all();
        } catch(\Exception $e) {
            //可以加个log日志记录
            $this->response->errorNotFound($e->getMessage());
        }
    }

    public function login(Request $request) {
        $credentials = $request->only('account', 'password');
        try {
            $model = $this->repository->findOneByFiled('account', $request->input('account'));
            if(password_verify($credentials['password'], $model->password)) {
                $model->token = JWTAuth::fromUser($model, $model->toArray());//该token中包含了staff的一些信息
                return $model;
            }
            $this->response->errorUnauthorized('invalid_credentials');
        } catch (JWTException $e) {
            $this->response->errorInternal($e->getMessage());
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
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            $this->response->errorNotFound($e->getMessage());
//            throw new NotFoundHttpException($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

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
        try {
            return $this->repository->update($request->all(), $id);
        } catch (ValidatorException $e) {
            $this->response->errorBadRequest($e->getMessageBag());
//            throw new BadRequestHttpException($e->getMessageBag());
        } catch (\Exception $e) {
            $this->response->errorNotFound($e->getMessage());
//            throw new NotFoundHttpException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
        } catch (\Exception $e) {
            $this->response->errorNotFound($e->getMessage());
//            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
