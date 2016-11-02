<?php

namespace tecai\Models\User;

use tecai\Models\System\Account;

/**
 * tecai\Models\User\User
 *
 * @property integer $id
 * @property string $account
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property boolean $age
 * @property boolean $sex
 * @property boolean $school_level
 * @property string $school
 * @property string $college
 * @property string $major
 * @property string $id_card
 * @property string $native
 * @property string $province
 * @property string $city
 * @property string $address
 * @property integer $wants_job_id
 * @property string $wants_job_name
 * @property string $last_login_at
 * @property string $last_login_ip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereSchoolLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereSchool($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereCollege($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereMajor($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereIdCard($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereNative($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereWantsJobId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereWantsJobName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Account
{
    const SEX_FEMALE = 0;
    const SEX_MALE = 1;

    //如果不填该项，则数据表默认是模型名字的复数users
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

    //不允许一次性赋值的字段
//    protected $guarded = ['id','role','add_time','password','password_confirmation'];

    //protected $primaryKey = 'your_custom_primarykey' 默认为id

    public $timestamps = true;

}
