<?php
namespace tecai\Cache\Operations\Sets;

use Illuminate\Cache\RedisStore;
use Predis\ClientInterface;
use tecai\Cache\Operations\OperationInterface;

class RedisSets implements OperationInterface
{
    /**
     * @var RedisStore
     */
    protected $store;

    /**
     * @var ClientInterface
     */
    protected $redisConnection;

    /**
     * @var string
     */
    public $key = '';

    public function __construct(RedisStore $redisStore)
    {
        $this->store = $redisStore;
        $this->redisConnection = $this->store->connection();
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param int|string $values
     * @param null $_
     * @return int
     */
    public function add($values, $_ = null)
    {
        $values = func_get_args();

        return $this->redisConnection->sadd($this->key, (array) $values);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->redisConnection->scard($this->key);
    }

    /**
     * @param string $keys
     * @param string $_ [optional]
     * @return array
     */
    public function diff($keys, $_ = null)
    {
        return $this->redisConnection->sdiff(func_get_args());
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
        return $this->redisConnection->sdiffstore($destKey, $keys);
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
        return $this->redisConnection->sinter($keys);
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
        return $this->redisConnection->sinterstore($destKey, $keys);
    }

    /**
     * @param string $value
     * @return int
     */
    public function has($value)
    {
        return $this->redisConnection->sismember($this->key, $value);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->redisConnection->smembers($this->key);
    }

    /**
     * @param string $destKey
     * @param string $value
     * @return int
     */
    public function moveTo($destKey, $value)
    {
        return $this->redisConnection->smove($this->key, $destKey, $value);
    }

    /**
     * @param int $count [optional]
     * @return mixed
     */
    public function popRandom($count = null)
    {
        return $this->redisConnection->spop($this->key, $count);
    }

    /**
     * @param string $count [optional]
     * @return mixed
     */
    public function getRandom($count = null)
    {
        return $this->redisConnection->srandmember($this->key, $count);
    }

    /**
     * @param string $values
     * @param string $_ [optional]
     * @return int
     */
    public function remove($values, $_ = null)
    {
        $values = is_array($values) ? $values : func_get_args();
        return $this->redisConnection->srem($this->key, $values);
    }

    /**
     * @param string $key
     * @param string $_ [optional]
     * @return array
     */
    public function union($key, $_ = null)
    {
        return $this->redisConnection->sunion(func_get_args());
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
        return $this->redisConnection->sunionstore($destKey, $keys);
    }

    /**
     * @param int $cursor
     * @param array $options [optional]
     * @return array
     */
    public function iterate($cursor, array $options = null)
    {
        return $this->redisConnection->sscan($this->key, $cursor, $options);
    }





}