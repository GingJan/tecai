<?php

namespace tecai\Models\User;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Industry extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];

    protected $table = 'industries';

    protected $guarded = ['id','created_at'];

}
