<?php
namespace tecai\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use tecai\Repositories\Interfaces\CommonRepository;

abstract class CommonRepositoryEloquent extends BaseRepository implements CommonRepository {//这个抽象类其实没必要的，下面的方法是可以放入BaseRepository里

    public function findOneByField($field, $value = null, $columns = ['*']) {
        return parent::findByField($field,$value,$columns)->first();
    }

    public function listByLimit($where = null) {
        $model = $this->model;
        $where['limit'] = !empty($where['limit']) && $where['limit'] >= 0 ? $where['page'] : config('repository.pagination.limit', 10);
        $where['page'] = !empty($where['page']) && $where['page'] >= 1? ($where['page']-1)*$where['limit'] : 0;
        $where['rule'] = empty($where['rule']) ? 'created_at' : $where['rule'];
        $where['order'] = empty($where['order'])? 'DESC' : $where['order'];
        return $model::where('id','!=',1)
                ->skip($where['page'])
                ->take($where['limit'])
                ->orderBy($where['rule'], $where['order'])
                ->get();
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
