<?php

namespace tecai\Transformers;

/**
 * Class IndustryTransformer
 * @package namespace tecai\Transformers;
 */
class IndustryTransformer extends BaseTransformer
{

    /**
     * @param \tecai\Models\User\Industry $model
     * @return array
     */
    public function transformData($model)
    {
        $response = $model->toArray();
        return array_merge($response, [
            'id'         => (int) $model->id,
        ]);
    }
}
