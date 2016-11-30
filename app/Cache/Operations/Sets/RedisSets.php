<?php
namespace tecai\Cache\Operations\Sets;

use tecai\Cache\Operations\RedisOperation;

class RedisSets extends RedisOperation
{
    /**
     * @param callable $callback
     * @return array|mixed
     */
    public function getOrCache(\Closure $callback)
    {
        if (!empty($res = $this->getAll())) {
            return $res;
        }

        return $this->add($callback());
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
     * @return int
     */
    public function set($values)
    {
        return $this->add($values);
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
     * @return bool|int
     */
    public function setIfNotExists($values)
    {
        return !$this->connection->exists($this->key) ? $this->add($values) : false;
    }

    /**
     * @param int|string $values
     * @param int|string $_
     * @return int
     */
    public function add($values, $_ = null)
    {
        $values = is_array($values) ? $values : func_get_args();

        return $this->validity(function () use ($this, $values) {
            return $this->connection->sadd($this->key, (array) $values);
        });

    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->connection->scard($this->key);
    }

    /**
     * @param array|string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function diff($keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        array_unshift($keys, $this->key);
        return $this->connection->sdiff($keys);
    }

    /**
     * @param string $destKey
     * @param array|string $keys
     * @param string $_ [optional]
     * @return int
     */
    public function diffTo($destKey, $keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $keys[0] = $this->key;
        return $this->connection->sdiffstore($destKey, $keys);
    }

    /**
     * @param string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function inter($keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        array_unshift($keys, $this->key);
        return $this->connection->sinter($keys);
    }

    /**
     * @param string $destKey
     * @param array|string $keys
     * @param string $_ [optional]
     * @return int
     */
    public function interTo($destKey, $keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $keys[0] = $this->key;
        return $this->connection->sinterstore($destKey, $keys);
    }

    /**
     * @param array|string $value
     * @return bool
     */
    public function has($value, $all = false)
    {
        if (is_array($value)) {
            $this->connection->sadd('quark.temp', $value);
            return (bool) count($this->connection->sinter([$this->key, 'quark.temp']));
        }
        return (bool) $this->connection->sismember($this->key, $value);
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
    public function moveTo($destKey, $value, $minutes = null)
    {
        $minutes = $minutes ? : $this->defaultMinutes;
        if ($minutes > 0) {
            return $this->transaction(function () use ($this, $destKey, $value, $minutes){
                $res = $this->connection->smove($this->key, $destKey, $value);
                $this->connection->expire($destKey, $minutes);
                return $res;
            });
        }

        return $this->connection->move($this->key, $destKey, $value);
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
     * @param string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function union($keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        array_unshift($keys, $this->key);
        return $this->connection->sunion($keys);
    }

    /**
     * @param string $destKey
     * @param string $keys
     * @param string $_ [optional]
     * @return int
     */
    public function unionTo($destKey, $keys, $_ = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
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