<?php

namespace tecai\Models\System;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use tecai\Observers\RoleObserver;
use Zizaco\Entrust\EntrustRole;

/**
 * tecai\Models\System\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Account[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\tecai\Models\System\Permission[] $perms
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\System\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends EntrustRole implements Transformable
{
    use TransformableTrait;

    protected $table = 'roles';

    protected $fillable = ['name','display_name','description'];

    public static function boot() {
        parent::boot();
        static::observe(app(RoleObserver::class));
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
}
