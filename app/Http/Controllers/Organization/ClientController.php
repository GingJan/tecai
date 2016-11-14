<?php

namespace tecai\Http\Controllers\Organization;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Models\System\Account;
use tecai\Repositories\Interfaces\Organization\ClientRepository;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Transformers\CommonTransformer;

class ClientController extends Controller
{

    /**
     * @var ClientRepository
     */
    protected $repository;


    public function __construct(ClientRepository $repository)
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
        return $this->response()->paginator($this->repository->paginate(), new CommonTransformer());
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
            $attrs['type'] = Account::TYPE_ORGANIZATION;
            $accountRepository->create($attrs);//创建账户
            $model = $this->repository->create($request->all());//创建用户信息
            return $model;
        });

        return $this->response()->created(generateResourceURI() . '/'. $model->id);
    }


    /**
     * @param $account
     * @return mixed
     */
    public function show($account)
    {
        $model = is_numeric($account) ?
            $this->repository->find($account) : $this->repository->findOneByField('account',$account);
        return $this->response()->item($model, new CommonTransformer());
    }


    public function update(Request $request, $id)
    {
        if(is_numeric($id)) {
            $model = $this->repository->find($id, ['id', 'username', 'email', 'phone', 'id_card', 'status', 'last_login_at', 'last_login_ip', 'updated_time']);
        } else {
            $model = $this->repository->findOneByField('account', $id, ['id', 'username', 'email', 'phone', 'id_card', 'status', 'last_login_at', 'last_login_ip', 'updated_time']);
        }
        $this->repository->update($request->all(), $model->id);
        return $this->response()->noContent();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $account
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($account)
    {
        is_numeric($account) ?
            $this->repository->delete($account) : $this->repository->deleteByField('account', $account);
        return $this->response()->noContent();
    }
}
