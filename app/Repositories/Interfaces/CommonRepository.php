<?php
namespace tecai\Repositories\Interfaces;

interface CommonRepository {

    /**
     * 通过字段查找一条记录
     * @param       $field
     * @param       $value
     * @param array $columns
     * @return mixed
     */
    public function findOneByField($field, $value = null, $columns = ['*']);

    /**
     * 根据字段删除一条记录
     * @param string $field
     * @param string $value
     * @return mixed
     */
    public function deleteByField($field, $value);

    /**
     * 获取不可更新字段
     * @return array
     */
    public function getFieldUnchangeable();

}