<?php

namespace tecai\Transformers;

use tecai\Models\Organization\Corporation;

/**
 * Class CorporationTransformer
 * @package namespace tecai\Transformers;
 */
class CorporationTransformer extends BaseTransformer
{

    /**
     * Transform the Corporation entity
     * @param Corporation $model
     */
    public function transformData($model, $modelToArray)
    {
        return array_merge($modelToArray, [
            /* place the model properties you need to transform here */
            'is_listing' => $model->is_listing,
            'is_authentication' => $model->is_authentication,
            'is_shown' => $model->is_shown,
        ]);
    }
}
