<?php

use Illuminate\Database\Seeder;
use tecai\Models\System\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Permission::where('name', 'like', '%clients%')->get()->toArray();
        $corporations = Permission::where('name', 'like', '%corporations%')->get()->toArray();
        $jobs = Permission::where('name', 'like', '%jobs%')->get()->toArray();
        $users = Permission::where('name', 'like', '%users%')->get()->toArray();
        $tags = Permission::where('name', 'like', '%tags%')->get()->toArray();

        factory(\tecai\Models\System\Role::class, 'root')->create();

        $roleAdmin = factory(\tecai\Models\System\Role::class, 'admin')->create();
        $this->attachPermission($roleAdmin, $clients, $corporations, $jobs, $users, $tags);

        $roleLegaler = factory(\tecai\Models\System\Role::class, 'legaler')->create();
        $this->attachPermission($roleLegaler, $corporations, $jobs, $users, $tags);


    }

    /**
     * @param \tecai\Models\System\Role $role
     * @param Permission $perms
     */
    protected function attachPermission($role) {
        $perms = func_get_args();
        array_shift($perms);
//        dd($perms);
        foreach ($perms as $perm) {
            $method = 'attachPermission';
            $method = is_array($perm) ? $method . 's' : $method;
            $role->$method($perm);
        }

        $role->save();
    }
}
