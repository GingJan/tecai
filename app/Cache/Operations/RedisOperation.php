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

    public function __construct(RedisStore $redisStore)
    {
        $prefix = config('cache.prefix');
        $this->prefix = !empty($prefix) ? $prefix . ':' : '';
        $this->store = $redisStore;
        $this->connection = $this->store->connection();
        $this->minutes = config('cache.minutes', 60);
    }

    public function getRedisStore()
    {
        return $this->store;
    }

    protected function validity($minutes)
    {
        $minutes = is_null($minutes) ? $this->mintes : $minutes;

        if ($minutes > 0) {
            $this->connection->expire($this->key, $minutes * 60);
        }
    }

    public function transaction(\Closure $callback)
    {
        $this->connection->multi();
        call_user_func($callback);
        $this->connection->exec();
    }



    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $this->prefix . $key;
        return $this;
    }

}