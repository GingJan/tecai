<?php

namespace tecai\Repositories\User;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\User\SchoolRepository;
use tecai\Models\User\School;
use tecai\Repositories\CommonRepositoryEloquent;


/**
 * Class SchoolRepositoryEloquent
 * @package namespace tecai\Repositories\User;
 */
class SchoolRepositoryEloquent extends CommonRepositoryEloquent implements SchoolRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'max:15', 'unique:schools,name'],
            'level' => ['required', 'numeric'],
            'city' => ['required', 'max:7'],
            'address' => ['required', 'max:15'],
            'shortname' => ['sometimes', 'max:7'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['required', 'max:15', 'unique:schools,name'],
            'level' => ['required', 'numeric'],
            'city' => ['required', 'max:7'],
            'address' => ['required', 'max:15'],
            'shortname' => ['sometimes', 'max:7'],
        ],
    ];

    /**
     * 可作为查询条件字段
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'level',
        'city',
        'shortname'
    ];

    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return School::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attr) {
        $this->validator->with($attr)->passesOrFail(ValidatorInterface::RULE_CREATE);
        $attr['level'] = in_array($attr['level'], [School::LEVEL_985, School::LEVEL_211, School::LEVEL_ONE, School::LEVEL_TWO, School::LEVEL_THREE]) ? $attr['level'] : 0;
        return parent::create($attr);
    }

    public function update(array $attr, $id) {
        $attr['level'] = in_array($attr['level'], [School::LEVEL_985, School::LEVEL_211, School::LEVEL_ONE, School::LEVEL_TWO, School::LEVEL_THREE]) ? $attr['level'] : 0;
        return parent::update($attr, $id);
    }
}