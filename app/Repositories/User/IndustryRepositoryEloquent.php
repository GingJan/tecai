<?php

namespace tecai\Repositories\User;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Criteria\BaseCriteria;
use tecai\Repositories\Interfaces\User\IndustryRepository;
use tecai\Models\User\Industry;
use tecai\Repositories\CommonRepositoryEloquent;
use tecai\Validators\User\IndustryValidator;

/**
 * Class IndustryRepositoryEloquent
 * @package namespace tecai\Repositories\User;
 */
class IndustryRepositoryEloquent extends CommonRepositoryEloquent implements IndustryRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => ['required', 'max:31'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['sometimes', 'max:31'],
        ],
    ];

    protected $fieldSearchable = [
        'name',
    ];

    protected $fieldUnchangeable = [
        'id',
        'created_at',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Industry::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(BaseCriteria::class));
    }

}
