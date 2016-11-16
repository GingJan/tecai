<?php

namespace tecai\Models\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Resume extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'resumes';

    protected $guarded = ['id'];

}
