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


class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $users = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users.index', compact('users'));
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->repository->find($id);
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
            return $this->repository->update($request->all(), $id);
        } catch (ValidatorException $e) {
            $this->response->errorBadRequest($e->getMessageBag());
//            throw new BadRequestHttpException($e->getMessageBag());
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
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

    }
}
