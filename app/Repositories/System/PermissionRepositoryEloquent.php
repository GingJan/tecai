<?php

namespace tecai\Repositories\System;

use Illuminate\Contracts\Support\Arrayable;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Cache\Facades\Cache;
use tecai\Repositories\CommonRepositoryEloquent;
use tecai\Repositories\Interfaces\System\PermissionRepository;
use tecai\Models\System\Permission;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class PermissionRepositoryEloquent extends CommonRepositoryEloquent implements PermissionRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'unique:permissions,name', 'max:31'],
            'uri' => ['required', 'max:255'],
            'verb' => ['required', 'max:10'],
            'type' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'display_name' => ['sometimes', 'max:63'],
            'description' => ['sometimes', 'max:255'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['required','unique:permissions,name', 'max:31'],
            'uri' => ['required', 'max:255'],
            'verb' => ['required', 'max:10'],
            'type' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'display_name' => ['sometimes', 'max:63'],
            'description' => ['sometimes', 'max:255'],
        ],
    ];

    protected $fieldSearchable = [
        'name',
        'uri',
        'verb',
        'type',
        'status',
        'display_name',
    ];

    protected $fieldUnchangeable = [];

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
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attributes) {
        !empty($attributes['verb']) ? $attributes['verb'] = strtoupper($attributes['verb']) : false;
        $attributes['verb'] = in_array($attributes['verb'], [Permission::VERB_GET, Permission::VERB_POST, Permission::VERB_PUT_PATCH, Permission::VERB_DELETE]) ? $attributes['verb'] : '';
        $attributes['type'] = in_array($attributes['type'], [Permission::TYPE_PRIVATE, Permission::TYPE_PROTECTED, Permission::TYPE_PUBLIC])? $attributes['type'] : Permission::TYPE_PUBLIC;
        $attributes['status'] = !empty($attributes['status']) && $attributes['status'] == Permission::STATUS_CLOSE ? Permission::STATUS_CLOSE : Permission::STATUS_OPEN;

        return parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $attributes = array_unallow($this->getFieldUnchangeable(), $attributes);

        $attributes['type'] = in_array($attributes['type'], [Permission::TYPE_PRIVATE, Permission::TYPE_PROTECTED, Permission::TYPE_PUBLIC])? $attributes['type'] : Permission::TYPE_PUBLIC;
        $attributes['status'] = $attributes['status'] == Permission::STATUS_CLOSE ? Permission::STATUS_CLOSE : Permission::STATUS_OPEN;

        return parent::update($attributes, $id);
    }

    public function setCache($cacheTimes, $perms = null)
    {
//        $key = $this->cacheKey . 'perms:';

        if( $perms instanceof Arrayable) {
            foreach ($perms as $perm)
            {
                if ($perm::STATUS_OPENING == $perm->status)//关闭的资源是否应该还要放入缓存
                    Cache::hashs('perms:' . $perm->id)->set(['type'=>$perm->type, 'verb'=>$perm->verb, 'uri'=>$perm->uri]);
            }
        }

    }

    public function allFromCache($columns = null){
        $result = Cache::keys($this->cacheKey . 'perms:*')->sort();
        return empty($result) ? null : $result;
    }

    public function paginateFromCache($columns = null){
        $result = Cache::keys($this->cacheKey . 'perms:*')->sort(false, request('page', 1), config('repository.pagination.limit'));
        return empty($result) ? null : $result;
    }

    public function findFromCache($id, $columns = null) {
        dd($columns);
        return Cache::hashs('perms:' . $id)->get($columns);
    }
}
