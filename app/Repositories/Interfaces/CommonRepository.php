<?php
namespace tecai\Repositories\Interfaces;

interface CommonRepository {

    public function findOneByField($field, $value = null, $columns = ['*']);

    public function listByLimit($where = null);

    public function deleteByField($field, $value);

}