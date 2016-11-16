<?php

namespace tecai\Models\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class School extends Model implements Transformable
{
    use TransformableTrait;

    const LEVEL_985 = 10;
    const LEVEL_211 = 20;
    const LEVEL_ONE = 30;
    const LEVEL_TWO = 40;
    const LEVEL_THREE = 50;

    protected $table = 'schools';

    protected $guarded = ['id'];

    public $timestamps = false;
}
