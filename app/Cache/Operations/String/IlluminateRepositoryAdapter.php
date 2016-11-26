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
     * @param null $minutes
     * @return void
     */
    public function set($value, $minutes = null)
    {
        is_null($minutes) ?
            $this->illuminateCacheRepository->forever($this->key, $value) : $this->illuminateCacheRepository->put($this->key, $value, $minutes);
    }

    public function get()
    {
        return $this->illuminateCacheRepository->get($this->key);
    }

    public function setIfNotExists($value, $minutes)
    {
        $this->illuminateCacheRepository->add($this->key, $value, $minutes);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  \Closure  $callback
     * @param  \DateTime|int  $minutes
     * @return mixed
     */
    public function remember(\Closure $callback, $minutes = null)
    {
        return $this->illuminateCacheRepository->remember($this->key, $minutes, $callback);
    }

    public function remove()
    {
        return $this->illuminateCacheRepository->forget($this->key);
    }

    public function pull()
    {
        return $this->illuminateCacheRepository->pull($this->key, '');
    }
}
