<?php
namespace tecai\Cache\Operations\Lords;

use Illuminate\Cache\RedisStore;
use tecai\Cache\Operations\Operation;

class RedisKey extends Operation
{
    public function __construct(RedisStore $redisStore)
    {
        parent::__construct();
        $this->store = $redisStore;
        $this->connection = $this->store->connection();
    }

    public function setKey($keys)
    {
        $prefix = $this->key;
        foreach ((array) $keys as $key) {
            $this->key[] = $prefix . $key;
        }

        return $this;
    }

    public function set($values){}

    public function get($values){}

    /**
     * @return int
     */
    public function delete()
    {
        return $this->connection->del($this->key);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return $this->connection->dump($this->key);
    }

    /**
     * $return mixed
     */
    public function unserialize()
    {
//        return $this->connection->restore($this->key);//无此命令
    }


    /**
     * @return bool
     */
    public function exists()
    {
        return (bool) $this->connection->exists($this->key);
    }

    /**
     * @param $seconds
     * @return bool
     */
    public function expire($seconds)
    {
        return (bool) $this->connection->expire($this->key, $seconds);
    }

    /**
     * @param int $timestamp
     * @return bool
     */
    public function expireAt($timestamp)
    {
        $timestamp = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
        return (bool) $this->connection->expireat($this->key, $timestamp);
    }

    /**
     * @return bool
     */
    public function persistent()
    {
        return (bool) $this->connection->persist($this->key);
    }

    /**
     * @param int $seconds
     * @return bool
     */
    public function expireAsMilli($seconds)
    {
        return (bool) $this->connection->pexpire($this->key, $seconds);
    }

    /**
     * @param int $timestamp
     * @return bool
     */
    public function expireAtMilli($timestamp)
    {
        $timestamp = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
        return (bool) $this->connection->expireat($this->key, $timestamp);
    }

    /**
     * @return int
     */
    public function ttlAsMilli()
    {
        return $this->connection->pttl($this->key);
    }

    /**
     * @return int
     */
    public function ttl()
    {
        return $this->connection->ttl($this->key);
    }

    /**
     * @param string $host
     * @param string $port
     * @param string $destDatabase
     * @param string $timeout
     */
    public function migrate($host, $port, $destDatabase, $timeout)
    {
//        return $this->connection->migrate($host, $port, $this->key, $destDatabase, $timeout)//无此命令
    }

    /**
     * @param string $descDatabase
     * @return int
     */
    public function moveTo($descDatabase)
    {
        return $this->connection->move($this->key, $descDatabase);
    }

    //TODO 若redis返回错误，是否抛出指定的异常
    public function rename($newKeyName)
    {
        return $this->connection->rename($this->key, $newKeyName);
    }

    /**
     * @param string $newKeyName
     * @return bool
     */
    public function renameIfNotExists($newKeyName)
    {
        return (bool) $this->connection->renamenx($this->key, $newKeyName);
    }

    /**
     * @param bool $isChar
     * @param $offset
     * @param $take
     * @param $orderBy
     * @param $sortedBy
     * @param $destKey
     * @return array
     */
    public function sort($isChar = false, $offset, $take, $orderBy, $sortedBy, $destKey)
    {
        return $this->connection->sort($this->key);
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->connection->type($this->key);
    }

    /**
     * @param int $cursor
     * @return array
     */
    public function iterate($cursor)
    {
        return $this->connection->scan($cursor);
    }

    /**
     * 对本Key进行内部命令操作
     * @param string $command
     * @return mixed
     */
    public function innerCommand($command)
    {
        if (!str_contains(strtoupper($command), 'OBJECT')) {
            $command = 'OBJECT ' . $_COOKIE;
        }
        return $this->connection->object($command, $this->key);
    }


    /*不对指定key操作的方法*/
    /**
     * @return string
     */
    public function random()
    {
        return $this->connection->randomkey();
    }

    /**
     * @param $pattern
     * @return array
     */
    public function allKeys($pattern)
    {
        return $this->connection->keys($pattern);
    }






}