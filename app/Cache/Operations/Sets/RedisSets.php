<?php
namespace tecai\Cache\Operations\Sets;

use Illuminate\Cache\RedisStore;
use tecai\Cache\Operations\Operation;

class RedisSets extends Operation
{
    public function __construct(RedisStore $redisStore)
    {
        parent::__construct();
        $this->store = $redisStore;
        $this->connection = $this->store->connection();
    }

    public function clean()
    {
        return $this->connection->del($this->key);
    }

    //TODO
    public function remember($value, \Closure $callback, $minutes = null)
    {
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
     * @param string $values
     * @return array
     */
    public function get($values)
    {
        return $this->getAll();
    }


    /**
     * @param int|string $values
     * @param null $_
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