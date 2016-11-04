<?php

use Illuminate\Database\Seeder;
use tecai\Models\System\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actionMapVerb = [
            'get-all' => 'GET',
            'get-one' => 'GET',
            'create' => 'POST',
            'update' => 'PUT',
            'delete' => 'DELETE'
        ];
        $resource = [
            'admins',
            'permissions',
            'roles',
            'clients',
            'corporations',
            'jobs',
            'users',
            'tags'
        ];

        $records = [];

        array_map(function($r) use ($actionMapVerb, &$records) {
            foreach($actionMapVerb as $a => $v) {
                $name = $a . '-' . $r;
                $verb = $v;

                $r = $a == 'get-one' || $a == 'update' || $a == 'delete' ? $r . '/{id}' : $r;
                $uri = '/' . $r;

                $type = Permission::TYPE_PUBLIC;
                $status = Permission::STATUS_OPEN;
                $display_name = ucwords($name);
                $description = 'This is ' . $name . ' permission';
                $updated_at = $created_at = date('Y-m-d H:i:s');
                $records[] = compact('name', 'verb', 'uri', 'type', 'status', 'display_name', 'description', 'created_at', 'updated_at');
            }
        }, $resource);

        Permission::insert($records);
    }
}
