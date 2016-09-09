<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Model\System\Admin;
use tecai\Repositories\Interfaces\System\AdminRepository;

/**
 * Class AdminRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }



    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'username' => ['required', 'unique:admins','max:15'],
            'password' => ['required'],
            'email' => ['required','max:31'],
            'created_at' => ['required'],
            'updated_at' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'password' => ['sometimes'],
            'email' => ['sometimes','max:31'],
            'created_at' => ['required'],
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
        $attributes['last_login_at'] = $attributes['updated_at'] = $attributes['created_at'] = $formatTime;
        $attributes['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
        $attributes['password'] = bcrypt($attributes['password']);
        $r = parent::create($attributes);
        return $r;
    }

    public function update(array $attributes, $id) {
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['updated_at'] = $formatTime;
        return parent::update($attributes, $id);
    }
}
