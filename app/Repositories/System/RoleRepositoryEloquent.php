<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Contracts\CriteriaInterface;
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
    //使用外部自定义的Validator 类
//    public function validator() {
//        return RoleValidator::class;
//    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
//            'name' => 'sometimes|unique:roles,name',//somtimes和required一起使用？
            'name' => ['required', 'unique:roles','max:31'],
            'display_name' => ['sometimes','required','max:63'],
            'description' => ['sometimes','max:255'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
//            'name' => 'required|unique:roles,name',
            'name' => ['required','unique:roles,name', 'max:31'],
            'display_name' => ['sometimes','required','max:63'],
            'description' => ['sometimes','max:255'],
            'updated_at' => ['required'],
        ],
    ];

    protected $fieldSearchable = [
        'name',
        'display_name',
    ];

    protected $fieldUnchangeable = [
        'name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attributes) {
        //验证可以在这里进行
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $attributes['created_at'] = $formatTime;
        $r = parent::create($attributes);
        return $r;
    }

    public function update(array $attributes, $id) {
//        $attributes['updated_at'] = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);;
        return parent::update($attributes, $id);
    }

}
