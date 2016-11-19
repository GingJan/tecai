<?php

namespace tecai\Transformers;

use tecai\Models\System\Account;
use tecai\Models\User;

/**
 * Class UserTransformer
 * @package namespace tecai\Transformers;
 */
class AccountTransformer extends BaseTransformer
{

    /**
     * Transform the User entity
     *
     * @param Account $model
     * @param array $modelToArray
     * @return array
     */
    public function transformData($model, $modelToArray)
    {
        return array_merge($modelToArray, [
            'roles' => array_map(function($role) {
                return $role->getKey();
            },$model->roles->all())
        ]);
    }
}
