<?php
namespace tecai\Observers;

use tecai\Models\System\Permission;

class PermissionObserver
{
    /**
     * @param Permission $permission
     */
    public function saving($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function saved($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function creating($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function created($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function updating($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function updated($permission)
    {

    }

    /**
     * 删除permission时，相应的role-permission关系也要删除
     * @param Permission $permission
     */
    public function deleting($permission)
    {
//        $permission->roles()->detach();//不用在此detach，因为Entrust已经帮我们在它的EntrustPermissionTrait里注册了deleting模型事件对应的处理函数
    }

    /**
     * @param Permission $permission
     */
    public function deleted($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function restoring($permission)
    {

    }

    /**
     * @param Permission $permission
     */
    public function restored($permission)
    {

    }
}