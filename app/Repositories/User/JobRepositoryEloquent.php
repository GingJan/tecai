<?php

namespace tecai\Repositories\User;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Criteria\BaseCriteria;
use tecai\Repositories\Interfaces\User\JobRepository;
use tecai\Models\User\Job;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class JobRepositoryEloquent
 * @package namespace tecai\Repositories\User;
 */
class JobRepositoryEloquent extends CommonRepositoryEloquent implements JobRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'max:31'],
            'click' => ['sometimes', 'numeric', 'min:0'],//通过redis或者memcached在内存++
            'company_id' => ['required', 'numeric', 'min:0'],
            'company_name' => ['required', 'max:31'],
            'job_seq' => ['required', 'unique:jobs,job_seq'],
            'company_logo_url' => ['required', 'max:127'],
            'type' => ['required', 'numeric', 'min:0'],
            'salary' => ['required', 'between:1,15'],
            'work_time' => ['sometimes', 'max:7'],
            'work_city' => ['required', 'max:63'],
            'hr_id' => ['required', 'numeric'],
            'intro' => ['sometimes','max:510'],
            'is_shown' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'numeric'],
            'from_time' => ['required','date_format:Y-m-d H:i:s'],
            'to_time' => ['required','date_format:Y-m-d H:i:s'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['sometimes', 'max:31'],
            'click' => ['sometimes', 'numeric', 'min:0'],
            'company_id' => ['sometimes', 'numeric', 'min:0'],
            'company_name' => ['sometimes', 'max:31'],
            'company_logo_url' => ['sometimes', 'max:127'],
            'type' => ['sometimes', 'numeric', 'min:0'],
            'salary' => ['required', 'between:1,15'],
            'work_time' => ['sometimes', 'max:7'],
            'work_city' => ['sometimes', 'max:63'],
            'hr_id' => ['sometimes', 'numeric'],
            'intro' => ['sometimes'],
            'is_shown' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'numeric'],
            'from_time' => ['sometimes','date_format:Y-m-d H:i:s'],
            'to_time' => ['sometimes','date_format:Y-m-d H:i:s'],
        ],
    ];

    /**
     * 可作为查询条件字段
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'job_seq',
        'company_id',
        'company_name',
        'type',
        'salary',
        'work_city',
        'hr_id',
        'is_shown',
        'status',
        'from_time',
        'to_time',
        'created_at',
    ];

    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [
        'id',
        'job_seq',
        'created_at',
        'status',
        'click'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Job::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(BaseCriteria::class));
    }

    public function create(array $job) {
        $job['job_seq'] = uniqid();
        $job['click'] = 0;
        $from_time = strtotime($job['from_time']);
        $to_time = strtotime($job['to_time']);
        $now_time = time();
        $job['status'] =  $from_time > $now_time ? Job::STATUS_WAITING :
            $from_time <= $now_time && $to_time >= $now_time ?
                Job::STATUS_RUNNING : Job::STATUS_ENDING;
        $job['is_shown'] = isset($job['is_shown']) && intval($job['is_shown']) === Job::SHOW_YES ? Job::SHOW_YES : Job::SHOW_NOT;
        return parent::create($job);
    }

    public function update(array $job, $id) {
        $job = array_unallow($this->getFieldUnchangeable(), $job);

        $from_time = strtotime($job['from_time']);
        $to_time = strtotime($job['to_time']);
        $now_time = time();
        $job['status'] =  $from_time > $now_time ? Job::STATUS_WAITING :
            $from_time <= $now_time && $to_time >= $now_time ?
                Job::STATUS_RUNNING : Job::STATUS_ENDING;
        $job['is_shown'] = isset($job['is_shown']) && (intval($job['is_shown']) === Job::SHOW_YES) ? Job::SHOW_YES : Job::SHOW_NOT;
        return parent::update($job, $id);
    }
}
