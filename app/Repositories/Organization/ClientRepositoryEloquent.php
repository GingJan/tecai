<?php

namespace tecai\Repositories\Organization;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Validator\Contracts\ValidatorInterface;
use tecai\Repositories\Interfaces\Organization\ClientRepository;
use tecai\Models\Organization\Client;
use tecai\Repositories\CommonRepositoryEloquent;

/**
 * Class ClientRepositoryEloquent
 * @package namespace tecai\Repositories\Organization;
 */
class ClientRepositoryEloquent extends CommonRepositoryEloquent implements ClientRepository
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'account' => ['required', 'unique:accounts','max:31'],
            'username' => ['sometimes', 'unique:clients', 'max:31'],
            'email' => ['required', 'email', 'max:31','unique:users'],
            'phone' => ['required', 'regex:/^1[3|5|8]{1}[0-9]{1}[0-9]{8}$/', 'max:11', 'unique:users'],//这样验证为unique，但是数据表的索引是index
            'id_card' => ['required', 'unique:clients,id_card','max:18'],
            'type' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'last_login_at' => ['required','date_format:Y-m-d H:i:s', 'max:19'],
            'last_login_ip' => ['required','ip', 'max:15']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'username' => ['required', 'unique:clients', 'max:31'],
            'email' => ['required', 'email', 'max:31','unique:users'],
            'phone' => ['required', 'regex:/^1[3|5|8]{1}[0-9]{1}[0-9]{8}$/', 'max:11', 'unique:users'],//这样验证为unique，但是数据表的索引是index
            'id_card' => ['required', 'unique:clients,id_card','max:18'],
            'type' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'last_login_at' => ['required','date_format:Y-m-d H:i:s', 'max:19'],
            'last_login_ip' => ['required','ip', 'max:15']
        ],
    ];

    /**
     * 可作为查询条件字段
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'email',
        'phone',
        'id_card',
        'type',
        'status'
    ];

    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [
        'account',
        'type'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(CriteriaInterface::class));
    }

    public function create(array $attributes) {
        $attributes['username'] = empty($attributes['username'])? $attributes['account'] : $attributes['username'];
        $attributes['type'] = !empty($attributes['type']) && in_array($attributes['type'], [Client::TYPE_STAFF, Client::TYPE_BOSS])? Client::TYPE_STAFF : $attributes['type'];
        $attributes['status'] = Client::STATUS_CHECKING;
        $formatTime = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $attributes['last_login_at']  = $formatTime;
        $attributes['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
        parent::create($attributes);
    }

    public function update(array $attr, $id) {
        $attributes['type'] = !empty($attributes['type']) && in_array($attributes['type'], [Client::TYPE_STAFF, Client::TYPE_BOSS]) ? Client::TYPE_STAFF : $attributes['type'];

        if (!empty($attributes['status']) && !in_array($attributes['status'], [Client::STATUS_NORMAL, Client::STATUS_REJECTED, Client::STATUS_BANNED])) {
            unset($attributes['status']);
        }
        parent::update($attr, $id);
    }
}
