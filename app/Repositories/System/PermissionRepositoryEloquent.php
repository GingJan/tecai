<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use tecai\Models\System\Permission;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{

    protected $fieldSearchable = ['name','description'];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'unique:permissions','max:255'],
            'display_name' => ['sometimes','required','max:255'],
            'description' => ['sometimes','max:255'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|unique:permissions,name',
//            'name' => ['sometimes','required','unique:permissions,name']//somtimes和required一起使用？
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
}
