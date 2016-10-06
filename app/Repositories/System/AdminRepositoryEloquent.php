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
        $this->rules[ValidatorInterface::RULE_UPDATE]['email'][1] = 'unique:admins,email,'.$id;
        $attributes['updated_at'] = $formatTime;
        return parent::update($attributes, $id);
    }
}
