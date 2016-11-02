<?php

namespace tecai\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use tecai\Models\Organization\Corporation;
use tecai\Models\System\Account;

class CorporationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll(Account $account, Corporation $corporation) {
        return $account->roles
    }
}
