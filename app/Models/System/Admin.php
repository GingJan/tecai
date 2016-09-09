<?php

namespace tecai\Model\System;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Admin extends Model implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract,Transformable
{
    use Authenticatable, Authorizable, CanResetPassword, TransformableTrait,
        EntrustUserTrait {
        EntrustUserTrait::can insteadof Authorizable;
    }

    //如果不填该项，则数据表默认是模型名字的复数staffs
    protected $table = 'admins';

    //白名单（服务于create批量插入，允许的字段），fillable与guarded不可同时使用
    protected $fillable = ['username','password','email'];

    //黑名单（不允许的字段）
//    protected $guarded = ['id','role','add_time','password','password_confirmation'];

    protected $hidden = ['password'];

    //protected $primaryKey = 'your_custom_primarykey' 默认为id
    public $timestamps = false;

    public static $rules = [];

}
