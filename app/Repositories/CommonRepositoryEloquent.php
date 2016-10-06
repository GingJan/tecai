<?php
namespace tecai\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use tecai\Models\User\Job;
use tecai\Repositories\Interfaces\CommonRepository;

abstract class CommonRepositoryEloquent extends BaseRepository implements CommonRepository {//这个抽象类其实没必要的，下面的方法是可以放入BaseRepository里
    /**
     * 不可更新字段
     * @var array
     */
    protected $fieldUnchangeable = [];

    /**
     * 获取不可更新字段
     * @return array
     */
    public function getFieldUnchangeable() {
        return $this->fieldUnchangeable;
    }

    /**
     * 通过字段查找一条记录
     * @param       $field
     * @param       $value
     * @param array $columns
     * @return mixed
     */
    public function findOneByField($field, $value = null, $columns = ['*']) {
        return parent::findByField($field,$value,$columns)->first();
    }



    public function listByLimit($where = null) {
//        dd($where);
        $model = $this->model;
        $model = New Job();
//        $where['limit'] = !empty($where['limit']) && $where['limit'] >= 0 ? $where['page'] : config('repository.pagination.limit', 10);
//        $where['page'] = !empty($where['page']) && $where['page'] >= 1? ($where['page']-1)*$where['limit'] : 0;
        $where['sortedBy'] = empty($where['sortedBy']) ? 'created_at' : $where['sortedBy'];
        $where['orderBy'] = empty($where['orderBy'])? 'DESC' : $where['orderBy'];
        return $model->orderBy($where['sortedBy'], $where['orderBy'])
                ->paginate(10);
//                ->appends(['sort' => $where['sort']])
//                ->appends(['order' => $where['order']]);
    }

    public function deleteByField($field, $value) {

        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->findByField($field, $value, [$field]);//修改了这里，不一定非要通过主键id删除
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

}
