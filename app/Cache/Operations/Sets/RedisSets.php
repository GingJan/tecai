<?php
namespace tecai\Cache\Operations\Sets;

use tecai\Cache\Operations\RedisOperation;

class RedisSets extends RedisOperation
{
    public function clean()
    {
        return $this->connection->del($this->key);
    }

    public function getOrCache(\Closure $callback, $minutes = null)
    {
        if (!empty($res = $this->getAll())) {
            return $res;
        }

        $this->set($cache = $callback());
        $this->connection->expire($this->key, config('cache.minutes'));

        return $cache;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return (bool) $this->connection->exists($this->key);
    }

    /**
     * @param string $values
     * @param int $minutes
     * @return int
     */
    public function set($values, $minutes = null)
    {

        $res = $this->add($values);

        $this->validity($minutes);

        return $res;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->getAll();
    }

    /**
     * @param $values
     * @param null $minutes
     */
    public function setIfNotExists($values, $minutes = null)
    {
        if (!$this->connection->scard($this->key)) {
            $this->set($values, $minutes);
        }
    }

    /**
     * @param int|string $values
     * @param int|string $_
     * @return int
     */
    public function add($values, $_ = null)
    {
        if (!is_array($values)) {
            $values = func_get_args();
        }

        return $this->connection->sadd($this->key, (array) $values);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->connection->scard($this->key);
    }

    /**
     * @param string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function diff($keys, $_ = null)
    {
        return $this->connection->sdiff(func_get_args());
    }

    /**
     * @param string $destKey
     * @param string $keys
     * @param string $_ [optional]
     * @return int
     */
    public function diffTo($destKey, $keys, $_ = null)
    {
        $keys = array_shift(func_get_args());
        return $this->connection->sdiffstore($destKey, $keys);
    }

    /**
     * @param string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function inter($keys, $_ = null)
    {
        $keys = func_get_args();
        array_unshift($keys, $this->key);
        return $this->connection->sinter($keys);
    }

    /**
     * @param string $destKey
     * @param string $key
     * @param string $_ [optional]
     * @return int
     */
    public function interTo($destKey, $key, $_ = null)
    {
        $keys = func_get_args();
        $keys[0] = $this->key;
        return $this->connection->sinterstore($destKey, $keys);
    }

    /**
     * @param string $value
     * @return int
     */
    public function has($value)
    {
        return $this->connection->sismember($this->key, $value);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->connection->smembers($this->key);
    }

    /**
     * @param string $destKey
     * @param string $value
     * @return int
     */
    public function moveTo($destKey, $value)
    {
        return $this->connection->smove($this->key, $destKey, $value);
    }

    /**
     * @param int $count [optional]
     * @return mixed
     */
    public function popRandom($count = null)
    {
        return $this->connection->spop($this->key, $count);
    }

    /**
     * @param string $count [optional]
     * @return mixed
     */
    public function getRandom($count = null)
    {
        return $this->connection->srandmember($this->key, $count);
    }

    /**
     * @param string $values
     * @param string $_ [optional]
     * @return int
     */
    public function remove($values, $_ = null)
    {
        $values = is_array($values) ? $values : func_get_args();
        return $this->connection->srem($this->key, $values);
    }

    /**
     * @param string $key
     * @param string $_ [optional]
     * @return array
     */
    public function union($key, $_ = null)
    {
        return $this->connection->sunion(func_get_args());
    }

    /**
     * @param string $destKey
     * @param string $keys
     * @param string $_ [optional]
     * @return int
     */
    public function unionTo($destKey, $keys, $_ = null)
    {
        $keys = func_get_args();
        $keys[0] = $this->key;
        return $this->connection->sunionstore($destKey, $keys);
    }

    /**
     * @param int $cursor
     * @param array $options [optional]
     * @return array
     */
    public function iterate($cursor, array $options = null)
    {
        return $this->connection->sscan($this->key, $cursor, $options);
    }





}