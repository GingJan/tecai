<?php

namespace tecai\Http\Controllers\System;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Models\System\Permission;
use tecai\Models\System\Role;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use tecai\Repositories\Interfaces\System\RoleRepository;
use tecai\Transformers\CommonTransformer;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository) {
        $this->repository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //根据id查询，角色名查询，描述查询
        return $this->response()->paginator($this->repository->paginate(),new CommonTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $role = DB::transaction(function($db) use ($input) {
            //该闭包内的逻辑都处于事务中
            $role = $this->repository->create($input);
            //权限添加在模型观察器中处理。
            return $role;
        });
        return $this->response()->created(generateResourceURI() . '/' .$role->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->repository->with('permissions');
        $role = is_numeric($id) ? $role->find($id) : $role->findOneByField('name', $id);
        return $this->response()->item($role, new CommonTransformer());
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
        $input = $request->all();

        DB::transaction(function($db) use ($input, $id) {
            return $this->repository->update($input, $id);
        });

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
