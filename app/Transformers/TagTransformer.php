<?php

namespace tecai\Transformers;

use tecai\Models\Tag;

/**
 * Class TagTransformer
 * @package namespace tecai\Transformers;
 */
class TagTransformer extends BaseTransformer
{

    /**
     * Transform the Tag entity
     * @param Tag $model
     */
    public function transformData($model, $modelToArray)
    {
        return array_merge($modelToArray, [
            /* place the model properties you need to transform here */
        ]);
    }
}
