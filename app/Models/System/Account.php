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
use tecai\Observers\AccountObserver;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * tecai\Models\System\Account
 *
 * @property integer $id
 * @property string $account
 * @property string $password
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Account whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Account whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Account wherePassword($value)
 * @mixin \Eloquent
 */
class Account extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract,Transformable
{
    use Authenticatable, Authorizable, CanResetPassword, TransformableTrait,
        EntrustUserTrait {
        EntrustUserTrait::can insteadof Authorizable;
    }

    const TYPE_ADMIN = 10;
    const TYPE_ORGANIZATION = 20;
    const TYPE_USER = 30;
    protected $table = 'accounts';

    //白名单（服务于create批量插入，允许的字段），fillable与guarded不可同时使用
    protected $fillable = ['account','password','type'];

    protected $hidden = ['password'];

    public $timestamps = false;


    public static function boot() {
        parent::boot();

        parent::observe(AccountObserver::class);
    }
}
