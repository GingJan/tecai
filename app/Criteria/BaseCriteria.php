<?php
namespace tecai\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Job查询条件类
 * Class JobCriteria
 * @package tecai\Criteria
 */
class BaseCriteria implements CriteriaInterface {
    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository) {
        $reachable = $repository->getFieldsSearchable();
        $query = $this->request->query();
        $valid = array_allow($reachable, $query);
        $valid = array_map([$this, 'extractOperator'], $valid);
        foreach($valid as $field => $value) {
            $model = $model->where($field, $value['operator'], $value['value']);
        }

        $query['orderBy'] = !empty($query['orderBy']) && in_array($query['orderBy'], $reachable) ? $query['orderBy'] : config('repository.criteria.defaultField.orderBy', 'id');
        $query['sortedBy'] = !empty($query['sortedBy']) && strtoupper($query['sortedBy']) !== 'ASC' ? 'DESC' : 'ASC';

        $model = $model->orderBy($query['orderBy'], $query['sortedBy']);

        //在BaseRepository有一句：$this->model = $c->apply($this->model, $this);，因此必须返回$model对象
        return $model;
    }

    //TODO
    protected function sorting() {}

    protected function extractOperator($value) {
        $value = explode(':', $value);
        $operator = '=';

        //TODO like关键字的位置也可以随便放，目前只能按照这种格式name:like
        $pos = array_search('like', $value);
        if( $pos !== false) {
            unset($value[$pos]);
            $value[0] = '%'.$value[0].'%';
            $operator = 'like';
        }
        return ['operator' => $operator, 'value' => $value[0]];
    }



}
