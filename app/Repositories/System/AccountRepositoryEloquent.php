<?php

namespace tecai\Repositories\System;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\System\AccountRepository;
use tecai\Models\System\Account;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class AccountRepositoryEloquent
 * @package namespace tecai\Repositories\System;
 */
class AccountRepositoryEloquent extends CommonRepositoryEloquent implements AccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }



    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'account' => ['required', 'unique:accounts','max:31'],
            'password' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'password' => ['sometimes'],
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
        $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        $attributes['password'] = bcrypt($attributes['password']);
        return parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $attributes['password'] = bcrypt($attributes['password']);
        return parent::update($attributes, $id);
    }

}
