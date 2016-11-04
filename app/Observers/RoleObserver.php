<?php
namespace tecai\Observers;

use tecai\Models\System\Role;
use tecai\Repositories\Interfaces\System\PermissionRepository;

class RoleObserver
{
    /**
     * @param Role $role
     */
    public function saving($role)
    {

    }

    /**
     * 在创建和更新时，都会被调用
     * @param Role $role
     */
    public function saved($role)
    {
        $permission_id = app('request')->input('permission_id', '');

        if( !empty($permission_id) ) {
            if( !is_array($permission_id) ) {
                $permission_id = explode(',', $permission_id);
            }
            $permission = app(PermissionRepository::class)->find($permission_id);//找出多个permissions
            $role->attachPermissions($permission);//角色填加多个权限
        }
    }

    /**
     * @param Role $role
     */
    public function creating($role)
    {

    }

    /**
     * @param Role $role
     */
    public function created($role)
    {

    }

    /**
     * @param Role $role
     */
    public function updating($role)
    {

    }

    /**
     * role更新时，把旧的role-permission关系删除
     * @param Role $role
     */
    public function updated($role)
    {
        $role->perms()->detach();
    }

    /**
     * 删除role时，相应的role-permission关系也要删除
     * @param Role $role
     */
    public function deleting($role)
    {
//        $role->perms()->detach();//不用在此detach，因为Entrust已经帮我们在它的EntrustRoleTrait里注册了deleting模型事件对应的处理函数
    }

    /**
     * @param Role $role
     */
    public function deleted($role)
    {

    }

    /**
     * @param Role $role
     */
    public function restoring($role)
    {

    }

    /**
     * @param Role $role
     */
    public function restored($role)
    {

    }
}