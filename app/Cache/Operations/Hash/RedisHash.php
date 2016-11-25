<?php
namespace tecai\Cache\Operations\Hash;

use Illuminate\Cache\RedisStore;
use tecai\Cache\Operations\Operation;

class RedisHash extends Operation
{
    public function __construct(RedisStore $redisStore)
    {
        parent::__construct();
        $this->store = $redisStore;
        $this->connection = $this->store->connection();
    }

    public function clean()
    {
        $this->connection->del($this->key);
    }

    /**
     * @param array $_
     * @return int
     */
    public function set($_)
    {
        if (is_array($_)) {
            return $this->connection->hmset($this->key, $_);
        }
        list($field, $value) = func_get_args();
        return $this->connection->hset($this->key, $field, $value);
    }

    /**
     * @param string $field
     * @return array
     */
    public function get($field = '')
    {
        if (is_array($field))
            return $this->connection->hmget($this->key, $field);//返回多个field的值
        if (!empty($field))
            return $this->connection->hget($this->key, $field);//返回一个指定field的值
        else
            return $this->dump();//返回全部field=>$value的键值对
    }

    /**
     * 返回所有字段的值
     * @return array
     */
    public function getAll()
    {
        return $this->connection->hvals($this->key);
    }

    /**
     * @param string $field
     * @param int $num
     * @return int|string
     */
    public function increment($field, $num)
    {
        if (is_float($num))
            return $this->connection->hincrbyfloat($this->key, $field, $num);
        return $this->connection->hincrby($this->key, $field, $num);
    }

    /**
     * 获取所有字段名
     * @return array
     */
    public function getAllFieldsName()
    {
        return $this->connection->hkeys($this->key);
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    public function setIfNotExist($field, $value)
    {
        return (bool) $this->connection->hsetnx($this->key, $field, $value);
    }

    /**
     * 获取字段数
     * @return int
     */
    public function count()
    {
        return $this->connection->hlen($this->key);
    }

    /**
     * 获取某个字段的值的长度
     * @param string $field
     * @return int
     */
    public function valueLength($field)
    {
        return $this->connection->hstrlen($this->key, $field);
    }

    /**
     * @param string $field
     * @return int
     */
    public function has($field)
    {
        return $this->connection->hexists($this->key, $field);
    }

    /**
     * 获取全部的字段=>值的键值对
     * @return array
     */
    public function dump()
    {
        return $this->connection->hgetall($this->key);
    }

    /**
     * @param string $fields
     * @param string $_ [optional]
     * @return int
     */
    public function remove($fields, $_ = null)
    {
        $fields = is_array($fields) ? $fields : func_get_args();
        return $this->connection->hdel($this->key, $fields);
    }

    /**
     * @param int $cursor
     * @param string $pattern
     * @param int $count
     * @return array
     */
    public function iterate($cursor, $pattern = null, $count = null)
    {
        $options = [
            'pattern' => $pattern,
            'count' => $count
        ];
        return $this->connection->hscan($this->key, $cursor, $options);
    }

}