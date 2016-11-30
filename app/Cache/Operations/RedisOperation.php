<?php
namespace tecai\Cache\Operations;

use Illuminate\Cache\RedisStore;
use Illuminate\Contracts\Cache\Store;
use Predis\ClientInterface;

abstract class RedisOperation implements OperationInterface
{
    /**
     * @var Store
     */
    protected $store;

    /**
     * @var ClientInterface
     */
    protected $connection;

    /**
     * @var array|string
     */
    public $key;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var int
     */
    protected $minutes;

    /**
     * @var int
     */
    protected $defaultMinutes;

    /**
     * @param RedisStore $redisStore
     */
    public function __construct(RedisStore $redisStore)
    {
        $prefix = config('cache.prefix');
        $this->prefix = !empty($prefix) ? $prefix . ':' : '';

        $this->store = $redisStore;
        $this->connection = $this->store->connection();
        $this->defaultMinutes = config('cache.minutes', 60);
    }

    /**
     * @param string $key
     * @param int $minutes
     * @return $this
     */
    public function setKey($key, $minutes = null)
    {
        $this->key = $this->prefix . $key;
        $this->minutes = $minutes ? : $this->defaultMinutes;
        return $this;
    }

    /**
     * @return RedisStore|Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    protected function validity(\Closure $callback)
    {
        if ($this->minutes > 0) {

            $this->connection->multi();

            $res = call_user_func($callback);
//            call_user_func($callback, $this);

            $this->connection->expire($this->key, $this->minutes * 60);

            $this->connection->exec();

            return $res;
        }

        return call_user_func($callback);
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function transaction(\Closure $callback)
    {
        $this->connection->multi();
        $res = call_user_func($callback);
        $this->connection->exec();
        return $res;
    }

    /**
     * @return int
     */
    public function clean()
    {
        return $this->connection->del($this->key);
    }

}