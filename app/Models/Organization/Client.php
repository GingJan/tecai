<?php

namespace tecai\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use tecai\Models\System\Account;

class Client extends Account implements Transformable
{
    use TransformableTrait;

    const TYPE_STAFF = 10;
    const TYPE_BOSS = 20;

    protected $table = 'clients';

    protected $fillable = [
        'account',
        'username',
        'email',
        'phone',
        'id_card',
        'type',
        'status',
        'last_login_at',
        'last_login_ip'
    ];

    public $timestamps = true;

}
