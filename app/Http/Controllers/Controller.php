<?php

namespace tecai\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use tecai\Repositories\CommonRepositoryEloquent;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    /**
     * @var CommonRepositoryEloquent
     */
    protected $repository;

    protected function created($id = null, $content = null) {
        if( !is_null($id) ) {
            $id = app('api.url')->version(env('API_VERSION', 'v1'))->current() . '/' . $id;
        }
        return $this->response()->created($id, $content);
    }

    protected function findModel($id, $isNumeric = true, $field = 'id')
    {
        return ($isNumeric || is_numeric($id)) ?
            $this->repository->find($id) : $this->repository->findOneByField($field, $id);
    }
}
