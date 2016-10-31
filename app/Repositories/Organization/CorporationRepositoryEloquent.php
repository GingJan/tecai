<?php

namespace tecai\Repositories\Organization;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Criteria\BaseCriteria;
use tecai\Repositories\Interfaces\Organization\CorporationRepository;
use tecai\Models\Organization\Corporation;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class CorporationRepositoryEloquent
 * @package namespace tecai\Repositories\Organization;
 */
class CorporationRepositoryEloquent extends CommonRepositoryEloquent implements CorporationRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'legal_person_id' => ['required', 'numeric'],
            'legal_person_name' => ['required', 'between:1,7'],
            'name' => ['required', 'between:1,15'],
            'logo_img' => ['required', 'between:1,127'],
            'city' => ['required', 'between:1,63'],
            'address' => ['required', 'between:1,15'],
            'business' => ['required', 'between:1,255'],
            'industry' => ['required', 'between:1,15'],
            'financing' => ['required', 'between:1,15'],
            'status' => ['required','numeric'],
            'staff_num' => ['required','numeric'],
            'corporation_type' => ['required','between:1,7'],
            'tag_name' => ['sometimes', 'between:1,63'],
            'tag_id' => ['sometimes', 'between:1,63'],
            'phone' => ['sometimes', 'between:1,16'],
            'email' => ['sometimes', 'between:1,31'],
            'others' => ['sometimes', 'between:1,15'],
            'intro' => ['sometimes', 'max:1022'],
            'official_website' => ['sometimes', 'between:1,31'],
            'is_listing' => ['required','boolean'],
            'is_authentication' => ['sometimes','boolean'],
            'is_shown' => ['sometimes','boolean'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'legal_person_id' => ['required', 'numeric'],
            'legal_person_name' => ['required', 'between:1,7'],
            'name' => ['required', 'between:1,15'],
            'logo_img' => ['required', 'between:1,127'],
            'city' => ['required', 'between:1,63'],
            'address' => ['required', 'between:1,15'],
            'business' => ['required', 'between:1,255'],
            'industry' => ['required', 'between:1,15'],
            'financing' => ['required', 'between:1,15'],
            'status' => ['required','numeric'],
            'staff_num' => ['required','numeric'],
            'corporation_type' => ['required','between:1,7'],
            'tag_name' => ['sometimes', 'between:1,63'],
            'tag_id' => ['sometimes', 'between:1,63'],
            'phone' => ['sometimes', 'between:1,16'],
            'email' => ['sometimes', 'between:1,31'],
            'others' => ['sometimes', 'between:1,15'],
            'intro' => ['sometimes', 'max:1022'],
            'official_website' => ['sometimes', 'between:1,31'],
            'is_listing' => ['required','boolean'],
            'is_authentication' => ['sometimes','boolean'],
            'is_shown' => ['sometimes','boolean'],
        ],
    ];

    protected $fieldSearchable = [
        'legal_person_id',
        'legal_person_name',
        'name',
        'city',
        'address',
        'business',
        'industry',
        'financing',
        'status',
        'staff_num',
        'corporation_type',
        'tag_name',
        'tag_id',
        'phone',
        'email',
        'is_listing',
        'is_authentication',
        'is_shown',
    ];

    protected $fieldUnchangeable = [
        'id',
        'legal_person_id',//法人id不可变
        'created_at',
    ];


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Corporation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(BaseCriteria::class));
    }

    public function create(array $corporation) {
        $corporation['status'] = Corporation::APPROVAL;
        $corporation['tag_name'] = !empty($corporation['tag_name']) ? $corporation['tag_name'] : '';
        $corporation['tag_id'] = !empty($corporation['tag_id']) ? $corporation['tag_id'] : '';
        $corporation['phone'] = !empty($corporation['phone']) ? $corporation['phone'] : '';
        $corporation['email'] = !empty($corporation['email']) ? $corporation['email'] : '';
        $corporation['others'] = !empty($corporation['others']) ? $corporation['others'] : '';
        $corporation['intro'] = !empty($corporation['intro']) ? $corporation['intro'] : '';
        $corporation['official_website'] = !empty($corporation['official_website']) ? $corporation['official_website'] : '';
        $corporation['is_authentication'] = empty($corporation['is_authentication']) ? Corporation::AUTHENTICATION_NONE : Corporation::AUTHENTICATION_YES;
        $corporation['is_shown'] = empty($corporation['is_shown']) ? Corporation::HIDDEN : Corporation::SHOWN;
        return parent::create($corporation);
    }

}
