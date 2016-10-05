<?php
namespace tecai\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class JobCriteria implements CriteriaInterface {

    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository) {
        $searchable = array_flip($repository->getFieldsSearchable());//name=xxx&salary=xxx&time=xxx
        $query = $this->request->query();//name=xxx&salary=xxx&age=xxx
        $valid = array_intersect_key($query, $searchable);//name=xxx&salary=xxx
        $valid = array_map([$this, 'extractOperator'], $valid);

        foreach($valid as $field => $value) {
            $model = $model->where($field, $value['operator'], $value['value']);
//            $where[] = [$field, $value['operator'], $value['value']];
        }

        $query['sortedBy'] = empty($query['sortedBy']) ? 'created_at' : $query['sortedBy'];
        $query['orderBy'] = empty($query['orderBy'])? 'DESC' : $query['orderBy'];

        $model = $model->orderBy($query['sortedBy'], $query['orderBy']);
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
