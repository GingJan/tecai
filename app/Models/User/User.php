<?php

namespace tecai\Models\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use tecai\Models\System\Account;

class User extends Account
{
    //如果不填该项，则数据表默认是模型名字的复数staffs
    protected $table = 'users';

    //白名单（服务于create批量插入，允许的字段），fillable与guarded不可同时使用
    protected $fillable = [
        'account',
        'username',
        'email',
        'phone',
        'age',
        'sex',
        'school_level',
        'school',
        'college',
        'major',
        'id_card',
        'native',
        'province',
        'city',
        'address',
        'wants_job_id',
        'wants_job_name',
        'last_login_at',
        'last_login_ip'
    ];

    //黑名单（不允许一次性赋值的字段）
//    protected $guarded = ['id','role','add_time','password','password_confirmation'];

    //protected $primaryKey = 'your_custom_primarykey' 默认为id

    public $timestamps = true;

}
