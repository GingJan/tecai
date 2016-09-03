<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use tecai\Repositories\Interfaces\System\RoleRepository;
use tecai\Models\System\Role;
use tecai\Validators\System\RoleValidator;

/**
 * Class RoleRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
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
        parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $formatTime;
        parent::update($attributes, $id);
    }

//    public function
}
