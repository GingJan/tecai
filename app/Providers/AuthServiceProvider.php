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
        $gate->before(function($user, $uri, $method) {
            $roles = $user->roles;

            $resource = explode('/', trim($uri, '/'))[0];

            foreach ($roles as $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $perm) {
                    if($perm::TYPE_PUBLIC == $perm->type) return true;

                    if($perm->uri == $uri && $perm->verb == $method) {
                        if($perm::TYPE_PRIVATE == $perm->type) {
                            return app($resource)->find(1, ['owner_id'])->owner_id == $user->id;
                        }
                        return true;
                    }
                }
            }

            return false;
        });
    }
}
