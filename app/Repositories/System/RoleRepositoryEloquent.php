<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\CommonRepositoryEloquent;
use tecai\Repositories\Interfaces\System\RoleRepository;
use tecai\Models\System\Role;

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
            'name' => ['required', 'unique:roles,name','max:31'],
            'display_name' => ['sometimes','max:63'],
            'description' => ['sometimes','max:255'],
            'permission_id' => ['sometimes', 'numeric'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['required','unique:roles,name', 'max:31'],
            'display_name' => ['sometimes', 'max:63'],
            'description' => ['sometimes', 'max:255'],
            'permission_id' => ['sometimes', 'numeric'],
        ],
    ];

    protected $fieldSearchable = [
        'name',
        'display_name',
    ];

    protected $fieldUnchangeable = [
//        'name',
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

    /**
     * @param array $attributes
     * @return Role
     */
    public function create(array $attributes) {
        //验证可以在这里进行
        return parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $attributes = array_unallow($this->getFieldUnchangeable(), $attributes);
        return parent::update($attributes, $id);
    }
}
