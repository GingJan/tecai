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
use tecai\Models\User\User;
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
        return $this->response()->paginator($this->repository->paginate(), new CommonTransformer());
    }

    /**
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function store(Request $request, AccountRepository $accountRepository)
    {
        if (User::WAY_PHONE == $request->get('way')) {
            //调用 手机注册服务
        }

        //邮箱注册
        $attrs = $request->only('account', 'password');
        $attrs['type'] = Account::TYPE_USER;
        if (is_numeric($attrs['account'])) {
            $this->response()->errorBadRequest('account 不可为全数字');
        }

        $model = DB::transaction( function ($db) use ($attrs, $accountRepository, $request) {
                    $accountRepository->create($attrs);//创建账户
                    $user = $request->all();
                    $user['email'] = $user['account'];
                    $model = $this->repository->create($user);//创建用户信息
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
        return $this->response()->item($this->findModel($account, false, 'account'), new CommonTransformer());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(), $id);
        return $this->response()->noContent();
    }

    /**
     * @param $account
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($account)
    {
        $this->findModel($account, false, 'account')->delete();
        return $this->response()->noContent();
    }
}
