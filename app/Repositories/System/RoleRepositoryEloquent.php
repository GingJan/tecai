<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\CommonRepositoryEloquent;
use tecai\Repositories\Interfaces\System\RoleRepository;
use tecai\Models\System\Role;
use tecai\Validators\RoleValidator;

/**
 * Class RoleRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class RoleRepositoryEloquent extends CommonRepositoryEloquent implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    //使用外部自定义的Validator 类
//    public function validator() {
//        return RoleValidator::class;
//    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
//            'name' => 'sometimes|unique:roles,name',//somtimes和required一起使用？
            'name' => ['required', 'unique:roles','max:255'],
            'display_name' => ['sometimes','required','max:255'],
            'description' => ['sometimes','max:255'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|unique:roles,name',//somtimes和required一起使用？
//            'name' => ['sometimes','required','unique:roles,name']//somtimes和required一起使用？
            'display_name' => ['sometimes','required','max:255'],
            'description' => ['sometimes','max:255'],
            'updated_at' => ['required'],
        ],
    ];
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function create(array $attributes) {
        //验证可以在这里进行
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $attributes['created_at'] = $formatTime;
        $r = parent::create($attributes);
        return $r;
    }

    public function update(array $attributes, $id) {
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $formatTime;
        return parent::update($attributes, $id);
    }

//    public function
}
