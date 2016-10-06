<?php

namespace tecai\Models\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * tecai\Models\User\Job
 *
 * @property integer $id
 * @property string $job_seq
 * @property string $name
 * @property integer $click
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_logo_url
 * @property boolean $type
 * @property string $salary
 * @property string $work_time
 * @property string $work_city
 * @property integer $hr_id
 * @property string $intro
 * @property boolean $is_shown
 * @property boolean $status
 * @property string $from_time
 * @property string $to_time
 * @property string $industry
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $module
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereJobSeq($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereClick($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereCompanyName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereCompanyLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereWorkTime($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereWorkCity($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereHrId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereIsShown($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereFromTime($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereToTime($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereIndustry($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\User\Job whereModule($value)
 * @mixin \Eloquent
 */
class Job extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'jobs';

    const STATUS_WAITING = 10;
    const STATUS_RUNNING = 20;
    const STATUS_ENDING  = 30;

    const SHOW_NOT = 0;
    const SHOW_YES = 1;

    const TYPE_PRACTICE = 10;//实习
    const TYPE_CAMPUS = 20;//校招
    const TYPE_SOCIAL = 30;//社招

    protected $fillable = [
        'name',
        'job_seq',
        'company_id',
        'company_name',
        'company_logo_url',
        'type',
        'salary',
        'work_time',
        'work_city',
        'hr_id',
        'intro',
        'is_shown',
        'status',//由后台自动填充
        'from_time',
        'to_time',
        'industry',
    ];

    protected static $status = [
        self::STATUS_WAITING => '未开始',
        self::STATUS_RUNNING => '进行中',
        self::STATUS_ENDING => '已结束',
    ];

    protected static $type = [
        self::TYPE_PRACTICE => '实习',
        self::TYPE_CAMPUS => '校招',
        self::TYPE_SOCIAL => '社招',
    ];

    public function getTypeStringify() {
        return static::$type[$this->type];
    }

    public function getStatusStringify() {
        return static::$status[$this->status];
    }

    public function isShown() {
        return boolval($this->is_shown);
    }



}
