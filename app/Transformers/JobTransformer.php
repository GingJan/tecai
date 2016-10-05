<?php
namespace tecai\Transformers;

use tecai\Models\User\Job;

class JobTransformer extends BaseTransformer {

    /**
     * @param \tecai\Models\User\Job $model
     * @return array
     */
    protected function transformData($model) {//Job $model
        $response = $model->toArray();

        return array_merge($response, [
            'type' => $model->getTypeStringify(),
            'is_shown' => $model->isShown(),
            'work_city' => explode(',', $model->work_city),
            'status' => $model->getStatusStringify(),
            'from_time_timestamp' => strtotime($model->from_time),
            'to_time_timestamp' => strtotime($model->to_time),
            'created_at' => $model->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $model->updated_at->format('Y-m-d H:i:s'),
        ]);
    }

}