<?php

namespace tecai\Repositories\User;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\User\UserRepository;
use tecai\Models\User\User;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class UserRepositoryEloquent
 * @package namespace tecai\Repositories\User;
 */
class UserRepositoryEloquent extends CommonRepositoryEloquent implements UserRepository
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'account' => ['required', 'unique:admins','max:31'],
            'username' => ['required', 'unique:users', 'max:31'],
            'email' => ['required', 'email', 'max:31','unique:users'],
            'phone' => ['sometimes', 'regex:/^1[3|5|8]{1}[0-9]{1}[0-9]{8}$/', 'max:11', 'unique:users'],//这样验证为unique，但是数据表的索引是index
            'age' => ['sometimes', 'numeric', 'min:0'],
            'sex' => ['sometimes', 'boolean'],
            'school' => ['sometimes', 'max:31'],
            'college' => ['sometimes', 'max:31'],
            'major' => ['sometimes', 'max:15'],
            'native' => ['sometimes', 'max:15'],
            'province' => ['sometimes', 'max:5'],
            'city' => ['sometimes', 'max:7'],
            'address' => ['sometimes', 'max:31'],
            'wants_job_name' => ['sometimes', 'max:31'],
            'last_login_at' => ['sometimes','date_format:Y-m-d H:i:s'],
            'last_login_ip' => ['sometimes','ip']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'username' => ['required', 'max:31', 'unique:users'],
            'email' => ['sometimes', 'email', 'max:31', 'unique:users'],
            'phone' => ['sometimes', 'regex:/^1[3|5|8]{1}[0-9]{1}[0-9]{8}$/', 'max:11', 'unique:users'],
            'age' => ['sometimes', 'numeric', 'min:0'],
            'sex' => ['sometimes', 'boolean'],
            'school' => ['sometimes', 'max:31'],
            'college' => ['sometimes', 'max:31'],
            'major' => ['sometimes', 'max:15'],
            'native' => ['sometimes', 'max:15'],
            'province' => ['sometimes', 'max:5'],
            'city' => ['sometimes', 'max:7'],
            'address' => ['sometimes', 'max:31'],
            'wants_job_name' => ['sometimes', 'max:31'],
            'last_login_at' => ['sometimes','date_format:Y-m-d H:i:s'],
            'last_login_ip' => ['sometimes','ip']
        ],
    ];

    protected $fieldSearchable = [
        'username',
        'email',
        'phone',
        'age',
        'sex',
        'school_level',
        'school',
        'college',
        'province',
        'city',
        'wants_job_id',
        'wants_job_name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
        return parent::create($attributes);
    }

    public function update(array $attributes, $id) {
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $this->rules[ValidatorInterface::RULE_UPDATE]['username'][2] = 'unique:users,username,'.$id;//如果要account作为except的话,unique:users,username,$account,account
        $this->rules[ValidatorInterface::RULE_UPDATE]['email'][3] = 'unique:users,email,'.$id;
        $this->rules[ValidatorInterface::RULE_UPDATE]['phone'][3] = 'unique:users,phone,'.$id;
        $attributes['updated_at'] = $formatTime;
        return parent::update($attributes, $id);
    }
}
