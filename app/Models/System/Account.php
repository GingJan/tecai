<?php

namespace tecai\Models\System;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Account extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract,Transformable
{
    use Authenticatable, Authorizable, CanResetPassword, TransformableTrait,
        EntrustUserTrait {
        EntrustUserTrait::can insteadof Authorizable;
    }

    protected $table = 'accounts';

    //白名单（服务于create批量插入，允许的字段），fillable与guarded不可同时使用
    protected $fillable = ['account','password'];

    protected $hidden = ['password'];

    public $timestamps = false;

}
