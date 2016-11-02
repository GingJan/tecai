<?php

namespace tecai\Models\System;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\EntrustPermission;

/**
 * tecai\Models\System\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission implements Transformable
{
    use TransformableTrait;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'uri',
        'verb',
        'type',
        'status',
        'display_name',
        'description'
    ];

    const VERB_GET = 'GET';
    const VERB_POST = 'POST';
    const VERB_PUT_PATCH = 'PUT';
    const VERB_DELETE = 'DELETE';

    const TYPE_PRIVATE = 10;
    const TYPE_PROTECTED = 20;
    const TYPE_PUBLIC = 30;

    const STATUS_OPEN = 0;
    const STATUS_CLOSE = 1;

    public function getRoles() {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }

}
