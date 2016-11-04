<?php

namespace tecai\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use tecai\Models\System\Permission;
use tecai\Models\System\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'tecai\Model' => 'tecai\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //注册权限检查策略
        $gate->before(function($user, $resource, $method) {
            $roles = $user->roles;

            foreach ($roles as $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $perm) {
                    if($perm->uri == $resource && $perm->verb == $method) {
                        return true;
                    }
                }
            }

            return false;
        });
    }
}
