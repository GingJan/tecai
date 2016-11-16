<?php
namespace tecai\Observers;

use tecai\Models\System\Account;
use tecai\Repositories\Interfaces\System\RoleRepository;

class AccountObserver
{
    /**
     * @param Account $account
     */
    public function saving($account)
    {

    }

    /**
     * @param Account $account
     */
    public function saved($account)
    {

    }

    /**
     * @param Account $account
     */
    public function creating($account)
    {

    }

    /**
     * @param Account $account
     */
    public function created($account)
    {
        switch($account->type) {
            case Account::TYPE_ADMIN :
                $role = app(RoleRepository::class)->findOneByField('name', 'admin');
                $account->attachRole($role);
                break;
            case Account::TYPE_ORGANIZATION :
                $role = app(RoleRepository::class)->findOneByField('name', 'client');
                $account->attachRole($role);
                break;
            default :
                break;
        }
    }

    /**
     * @param Account $account
     */
    public function updating($account)
    {

    }

    /**
     * @param Account $account
     */
    public function updated($account)
    {

    }

    /**
     * @param Account $account
     */
    public function deleting($account)
    {
//        $account->roles()->detach();//entrust已经处理
    }

    /**
     * @param Account $account
     */
    public function deleted($account)
    {

    }

    /**
     * @param Account $account
     */
    public function restoring($account)
    {

    }

    /**
     * @param Account $account
     */
    public function restored($account)
    {

    }
}