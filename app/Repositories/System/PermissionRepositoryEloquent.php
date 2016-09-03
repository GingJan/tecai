<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use tecai\Models\System\Permission;
use tecai\Validators\System\PermissionValidator;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{

    protected $fieldSearchable = [''];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
