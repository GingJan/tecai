<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Models\System\Admin;
use tecai\Repositories\Interfaces\System\AdminRepository;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class AdminRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class AdminRepositoryEloquent extends CommonRepositoryEloquent implements AdminRepository
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'account' => ['required', 'unique:admins','max:31'],
            'username' => ['required', 'unique:users', 'max:31'],
            'email' => ['required','unique:admins','max:31','email'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'email' => ['sometimes','unique:admins','max:31','email'],
        ],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function create(array $attributes) {
        //验证可以在这里进行
        $attributes['username'] = empty($attributes['username'])? $attributes['account'] : $attributes['username'];
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['last_login_at']  = $formatTime;
        $attributes['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
//        dd($attributes);
        return parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $formatTime;
        return parent::update($attributes, $id);
    }

    public function findOne($field, $value = null, $columns = ['*']) {
        return parent::findByField($field,$value,$columns)->first();
    }

    public function listByLimit($where = null) {
        $model = $this->model;
        $where['page'] = empty($where['page'])? 1 : $where['page'];
        $where['limit'] = empty($where['limit'])? config('repository.pagination.limit', 10) : $where['page'];
        $where['rule'] = empty($where['rule'])? 'created_at' : $where['rule'];
        $where['order'] = empty($where['order'])? 'DESC' : $where['order'];
        $model::where('id','!=',1)
            ->skip($where['page'])
            ->take($where['limit'])
            ->orderBy($where['rule'], $where['order'])
            ->get();
    }
}
