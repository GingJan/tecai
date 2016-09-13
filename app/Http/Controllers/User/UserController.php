<?php

namespace tecai\Http\Controllers\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use tecai\Http\Controllers\Controller;
use tecai\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Repositories\Interfaces\User\UserRepository;


class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $repository;


    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $res = $this->repository->listByLimit($request->getQueryString());
            return $res;
        } catch(\Exception $e) {
            $this->response->errorNotFound($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function store(Request $request, AccountRepository $accountRepository)
    {
        try {
            DB::beginTransaction();
            $accountRepository->create($request->only('account','password'));//创建账户
            $model = $this->repository->create($request->all());//创建用户信息
            DB::commit();
            return $model;
        } catch (ValidatorException $e) {
            DB::rollback();
            //log,记录日志的方式是通过事件来实现
//            $this->response->errorBadRequest($e->getMessageBag());
            throw new BadRequestHttpException($e->getMessageBag());
        }
    }


    /**
     * @param $account
     * @return mixed
     */
    public function show($account)
    {
        try {
            return $this->repository->findOneByField('account',$account);
        } catch (NotFoundHttpException $e) {
//            $this->response->errorNotFound($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            //log $e;
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $model = $this->repository->findOneByField('account',$id);
            return $this->repository->update($request->all(), $model->id);
        } catch (ValidatorException $e) {
            throw new BadRequestHttpException($e->getMessageBag());
//            $this->response->errorBadRequest($e->getMessageBag());
        } catch (NotFoundHttpException $e) {
            throw $e;
//            $this->response->errorNotFound($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($account)
    {
        try {
            $this->repository->deleteByField('account', $account);
            return $this->response()->noContent();
        } catch (NotFoundHttpException $e) {
            return $this->response()->noContent();
        }
    }
}
