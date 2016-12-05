<?php
namespace tecai\Cache\Operations\String;

use Illuminate\Cache\RedisStore;
use tecai\Cache\Operations\RedisOperation;
use Illuminate\Contracts\Cache\Repository;

class IlluminateRepositoryAdapter extends RedisOperation
{
    /**
     * @var \Illuminate\Cache\Repository
     */
    protected $illuminateCacheRepository;

    /**
     * @param RedisStore $redisStore
     */
    public function __construct(RedisStore $redisStore)
    {
        parent::__construct($redisStore);
        $this->illuminateCacheRepository = app(Repository::class);
    }

    public function clean()
    {
//        $this->illuminateCacheRepository->getStore()->connection();
        $this->illuminateCacheRepository->forget($this->key);
    }

    public function exists()
    {
        return $this->illuminateCacheRepository->has($this->key);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function set($value)
    {
        $this->minutes < 0 ?
            $this->illuminateCacheRepository->forever($this->key, $value) : $this->illuminateCacheRepository->put($this->key, $value, $this->minutes);
    }

    public function get()
    {
        return $this->illuminateCacheRepository->get($this->key);
    }

    public function setIfNotExists($value)
    {
        $this->illuminateCacheRepository->add($this->key, $value, $this->minutes);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  \Closure  $callback
     * @return mixed
     */
    public function getOrCache(\Closure $callback)
    {
        return $this->illuminateCacheRepository->remember($this->key, $this->minutes, $callback);
    }

    public function remove()
    {
        return $this->illuminateCacheRepository->forget($this->key);
    }

    public function pop()
    {
        return $this->illuminateCacheRepository->pull($this->key);
    }
}
