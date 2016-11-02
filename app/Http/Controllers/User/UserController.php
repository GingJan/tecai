<?php

namespace tecai\Http\Controllers\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use tecai\Http\Controllers\Controller;
use tecai\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use tecai\Models\System\Account;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Repositories\Interfaces\User\UserRepository;
use tecai\Transformers\CommonTransformer;

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
        $model = DB::transaction( function($db) use($request, $accountRepository) {
                    $attrs = $request->only('account', 'password');
                    $attrs['type'] = Account::TYPE_USER;
                    $accountRepository->create($attrs);//创建账户
                    $model = $this->repository->create($request->all());//创建用户信息
                    return $model;
                });
        //log,记录日志的方式是通过事件来实现
        return $this->response()->created(generateResourceURI() . '/'. $model->id);
    }


    /**
     * @param $account
     * @return mixed
     */
    public function show($account)
    {
        return $this->response()->item($this->repository->findOneByField('account',$account), new CommonTransformer());
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
