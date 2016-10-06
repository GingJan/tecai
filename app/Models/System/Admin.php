<?php

namespace tecai\Models\System;

/**
 * tecai\Models\System\Admin
 *
 * @property integer $id
 * @property string $account
 * @property string $username
 * @property string $email
 * @property string $last_login_at
 * @property string $last_login_ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereLastLoginAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereLastLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
