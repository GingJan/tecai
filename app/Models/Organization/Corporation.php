<?php

namespace tecai\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * tecai\Models\Organization\Corporation
 *
 * @property integer $id
 * @property integer $legal_person_id
 * @property string $legal_person_name
 * @property string $name
 * @property string $logo_img
 * @property string $city
 * @property string $address
 * @property string $business
 * @property string $tag_name
 * @property string $tag_id
 * @property string $phone
 * @property string $email
 * @property string $official_website
 * @property string $intro
 * @property string $others
 * @property string $industry
 * @property string $financing
 * @property string $corporation_type
 * @property integer $status
 * @property integer $staff_num
 * @property boolean $is_listing
 * @property boolean $is_authentication
 * @property boolean $is_shown
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereLegalPersonId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereLegalPersonName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereLogoImg($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereBusiness($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereTagName($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereOfficialWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereOthers($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereIndustry($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereFinancing($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereCorporationType($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereIsListing($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereIsAuthentication($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereIsShown($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereStaffNum($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\tecai\Models\Organization\Corporation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Corporation extends Model implements Transformable
{
    use TransformableTrait;

    const APPROVAL  = 10;//待审核
    const NORMAL    = 20;//正常/通过审核
    const BANNED    = 30;//禁止
    const ILLEGAL   = 40;//审核不通过

    const AUTHENTICATION_NONE = 0;
    const AUTHENTICATION_YES = 1;

    const HIDDEN = 0;
    const SHOWN = 1;

    protected $table = 'corporations';

//    protected $fillable = [
//        'legal_person_id',
//        'legal_person_name',
//        'name',
//        'intro',
//        'logo_img',
//        'city',
//        'phone',
//        'email',
//        'address',
//        'business',
//        'tag_name',
//        'tag_id',
//        'others',
//        'industry',
//        'financing',
//        'official_website',
//        'corporation_type',
//        'is_listing',
//        'is_authentication',
//        'is_shown',
//        'status',
//        'staff_num',
//    ];

    protected $guarded = [
        'id',
    ];

}
