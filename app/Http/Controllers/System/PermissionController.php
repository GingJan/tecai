<?php

namespace tecai\Http\Controllers\System;

use Illuminate\Http\Request;

use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use tecai\Transformers\CommonTransformer;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $repository;

    /**
     * @param PermissionRepository $permissionRepository
     *
     */
    public function __construct(PermissionRepository $permissionRepository) {//注入仓库接口
        $this->repository = $permissionRepository;
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
        $model = $this->repository->create($request->all());
        return $this->response()->created(generateResourceURI() . '/' .$model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = is_numeric($id) ? $this->repository->find($id) : $this->repository->findOneByField('name', $id);
        return $this->response()->item($permission, new CommonTransformer());
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
