<?php

namespace tecai\Repositories\Common;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\Common\TagRepository;
use tecai\Models\Common\Tag;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class TagRepositoryEloquent
 * @package namespace tecai\Repositories\Common;
 */
class TagRepositoryEloquent extends CommonRepositoryEloquent implements TagRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'type' => ['required', 'numeric'],
            'name' => ['required', 'max:7'],
        ],
    ];

    /**
     * 可作为查询条件字段
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [
        'type',
        'name'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attr) {
        //Code goes here
        $attr['type'] = !empty($attr['type']) && Tag::Organization == $attr['type'] ? Tag::Organization : Tag::User;
        parent::create($attr);
    }

}
