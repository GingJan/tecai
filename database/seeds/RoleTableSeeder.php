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

        \tecai\Models\System\Role::create([
            'name' => 'root',
            'display_name' => 'Super Admin',
            'description' => 'the root account,Super Admin'
        ]);

        $roleAdmin = \tecai\Models\System\Role::create([
            'name' => 'admin',
            'display_name' => 'platform Admin',
            'description' => 'the guy to admin the platform'
        ]);
        $this->attachPermission($roleAdmin, $clients, $corporations, $jobs, $users, $tags);


        $roleLegaler = \tecai\Models\System\Role::create([
            'name' => 'legaler',
            'display_name' => 'corporation-legaler',
            'description' => 'the corporation legal person'
        ]);
        $this->attachPermission($roleLegaler, $corporations, $jobs, $users, $tags);

        $roleStaff = \tecai\Models\System\Role::create([
            'name' => 'staff',
            'display_name' => 'corporation-staff',
            'description' => 'the corporation staff'
        ]);
        $this->attachPermission($roleStaff, $corporations, $jobs, $users, $tags);

    }

    /**
     * @param \tecai\Models\System\Role $role
     * @param Permission $perms
     */
    protected function attachPermission($role) {
        $perms = func_get_args();
        array_shift($perms);

        foreach ($perms as $perm) {
            $method = 'attachPermission';
            $method = is_array($perm) ? $method . 's' : $method;
            $role->$method($perm);
        }

        $role->save();
    }
}
