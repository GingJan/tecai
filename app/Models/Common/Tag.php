<?php

namespace tecai\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * tecai\Models\Common\Tag
 *
 * @property integer $id
 * @property boolean $type
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Common\Tag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Common\Tag whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Common\Tag whereName($value)
 * @mixin \Eloquent
 */
class Tag extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'tags';

    protected $fillable = ['type', 'name'];

}
