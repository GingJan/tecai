<?php

namespace tecai\Models\System;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use tecai\Models\System\Account;
use tecai\Models\System\User;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Admin extends Account
{
    //如果不填该项，则数据表默认是模型名字的复数staffs
    protected $table = 'admins';

    //白名单（服务于create批量插入，允许的字段），fillable与guarded不可同时使用
    protected $fillable = ['account', 'username', 'email', 'last_login_at', 'last_login_ip'];

    //黑名单（不允许一次性赋值的字段）
//    protected $guarded = ['id','role','add_time','password','password_confirmation'];

    //protected $primaryKey = 'your_custom_primarykey' 默认为id

    public $timestamps = true;

}
