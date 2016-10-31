<?php

namespace tecai\Transformers;

/**
 * Class CommonTransformer
 * @package namespace tecai\Transformers;
 */
class CommonTransformer extends BaseTransformer
{

    /**
     * Transform the entity
     * @param $model
     */
    public function transformData($model, $modelToArray)
    {
        return array_merge($modelToArray, [
            /* place the model properties you need to transform here */
        ]);
    }
}
