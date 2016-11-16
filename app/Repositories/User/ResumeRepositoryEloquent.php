<?php

namespace tecai\Repositories\User;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\User\ResumeRepository;
use tecai\Models\User\Resume;
use tecai\Repositories\CommonRepositoryEloquent;
//use tecai\Validators\User\ResumeValidator;

/**
 * Class ResumeRepositoryEloquent
 * @package namespace tecai\Repositories\User;
 */
class ResumeRepositoryEloquent extends CommonRepositoryEloquent implements ResumeRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => ['required', 'numeric'],
            'intro' => ['sometimes', 'max:510'],
            'experience' => ['sometimes', 'max:1020'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => ['required', 'numeric'],
            'intro' => ['sometimes', 'max:510'],
            'experience' => ['sometimes', 'max:1020'],
        ],
    ];

    /**
     * 可作为查询条件字段
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [
        'user_id',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Resume::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attr) {
//        $attr['user_id'] = ;//from jwt
        return parent::create($attr);
    }

    public function update(array $attr, $id) {
        //Code goes here
        return parent::update($attr, $id);
    }
}
