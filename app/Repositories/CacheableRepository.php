<?php

namespace tecai\Repositories;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Helpers\CacheKeys;
use ReflectionObject;
use Exception;

/**
 * Class CacheableRepository
 */
trait CacheableRepository
{
    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $eventDispatcher;
    /**
     * @var CacheRepository
     */
    protected $cacheRepository = null;

    protected $cacheKey;

    /**
     * Set Cache Repository
     *
     * @param CacheRepository $repository
     *
     * @return $this
     */
    public function setCacheRepository(CacheRepository $repository)
    {
        $this->cacheRepository = $repository;

        return $this;
    }

    public function setEventDispatcher(Dispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Fire an event for this cache instance.
     *
     * @param  string  $event
     * @param  array  $payload
     * @return void
     */
    protected function fireCacheEvent($event, $payload)
    {
        if (isset($this->eventDispatcher)) {
            $this->eventDispatcher->fire('cache.'.$event, $payload);
        }
    }

    protected function setCache($cacheTimes, $data = null) {}

    protected function allFromCache($columns = null) {}

    protected function paginateFromCache($limit = null, $columns = null) {}
//
    protected function findFromCache($id, $columns = null) {}
//
//    protected function findByFieldFromCache($field, $columns = null) {}
//
//    protected function findWhereFromCache($where, $columns = null) {}

    public function getByCriteriaFromCache($columns = null){}

    /**
     * Return instance of Cache Repository
     *
     * @return CacheRepository
     */
    public function getCacheRepository()
    {
        if (is_null($this->cacheRepository)) {
            $this->cacheRepository = app(config('repository.cache.repository', 'cache'));
        }

        return $this->cacheRepository;
    }

    /**
     * Skip Cache
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipCache($status = true)
    {
        $this->cacheSkip = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSkippedCache()
    {
        $skipped = isset($this->cacheSkip) ? $this->cacheSkip : false;
        $request = app('Illuminate\Http\Request');
        $skipCacheParam = config('repository.cache.params.skipCache', 'skipCache');

        if ($request->has($skipCacheParam) && $request->get($skipCacheParam)) {
            $skipped = true;
        }

        return $skipped;
    }

    /**
     * @param $method
     *
     * @return bool
     */
    protected function allowedCache($method)
    {
        $cacheEnabled = config('repository.cache.enabled', true);

        if (!$cacheEnabled) {
            return false;
        }

        $cacheOnly = isset($this->cacheOnly) ? $this->cacheOnly : config('repository.cache.allowed.only', null);
        $cacheExcept = isset($this->cacheExcept) ? $this->cacheExcept : config('repository.cache.allowed.except', null);

        if (is_array($cacheOnly)) {
            return in_array($method, $cacheOnly);
        }

        if (is_array($cacheExcept)) {
            return !in_array($method, $cacheExcept);
        }

        if (is_null($cacheOnly) && is_null($cacheExcept)) {
            return true;
        }

        return false;
    }

    /**
     * 获取指定类指定方法对应的key格式
     * Get Cache key for the method
     *
     * @param $method
     * @param $args
     *
     * @return string
     */
    public function getCacheKey($method, $args = null)
    {
        $request = app('Illuminate\Http\Request');
        $args = serialize($args);
        $criteria = $this->serializeCriteria();
        $key = sprintf('%s@%s-%s', get_called_class(), $method, md5($args . $criteria . $request->fullUrl()));

        CacheKeys::putKey(get_called_class(), $key);//保存 key 到文件

        return $key;

    }

    /**
     * Serialize the criteria making sure the Closures are taken care of.
     *
     * @return string
     */
    protected function serializeCriteria()
    {
        try {
            return serialize($this->getCriteria());
        } catch (Exception $e) {
            return serialize($this->getCriteria()->map(function ($criterion) {
                return $this->serializeCriterion($criterion);
            }));
        }
    }

    /**
     * Serialize single criterion with customized serialization of Closures.
     *
     * @param  \Prettus\Repository\Contracts\CriteriaInterface $criterion
     * @return \Prettus\Repository\Contracts\CriteriaInterface|array
     *
     * @throws \Exception
     */
    protected function serializeCriterion($criterion)
    {
        try {
            serialize($criterion);

            return $criterion;
        } catch (Exception $e) {
            // We want to take care of the closure serialization errors,
            // other than that we will simply re-throw the exception.
            if ($e->getMessage() !== "Serialization of 'Closure' is not allowed") {
                throw $e;
            }

            $r = new ReflectionObject($criterion);

            return [
                'hash' => md5((string) $r),
                'properties' => $r->getProperties(),
            ];
        }
    }

    /**
     * Get cache minutes
     *
     * @return int
     */
    public function getCacheMinutes()
    {
        $cacheMinutes = isset($this->cacheMinutes) ? $this->cacheMinutes : config('repository.cache.minutes', 30);

        return $cacheMinutes;
    }

    /**
     * 获取或设置缓存
     * @param array $getParams
     * @param callable $callback
     * @return mixed
     */
    protected function getOrSetCache(array $getParams, \Closure $callback)
    {
        $method = strtolower(array_shift($getParams));
        $result = call_user_func_array([$this, $method . 'FromCache'], $getParams);
        if (!is_null($result)) {
            return $result;
        }

        $value = $callback();
        call_user_func_array([$this, 'setCache'], [$this->getCacheMinutes(), $value]);
        $this->fireCacheEvent('write', [$this->cacheKey, $value]);
        return $value;
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        if (!$this->allowedCache('all') || $this->isSkippedCache()) {
            return parent::all($columns);
        }

        return $this->getOrSetCache(['all', $columns], function () use($columns) {
            return parent::all($columns);
        });
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null  $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'])
    {
        if (!$this->allowedCache('paginate') || $this->isSkippedCache()) {
            return parent::paginate($limit, $columns);
        }

        return $this->getOrSetCache(['paginate', $limit, $columns], function () use ($limit, $columns) {
            return parent::paginate($limit, $columns);
        });
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        if (!$this->allowedCache('find') || $this->isSkippedCache()) {
            return parent::find($id, $columns);
        }

        return $this->getOrSetCache(['find', $id, $columns], function () use ($id, $columns) {
            return parent::find($id, $columns);
        });
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        if (!$this->allowedCache('findByField') || $this->isSkippedCache()) {
            return parent::findByField($field, $value, $columns);
        }

        return $this->getOrSetCache(['findByField', $field, $value, $columns], function () use ($field, $value, $columns) {
            return parent::findByField($field, $value, $columns);
        });
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        if (!$this->allowedCache('findWhere') || $this->isSkippedCache()) {
            return parent::findWhere($where, $columns);
        }

        return $this->getOrSetCache(['findWhere', $where, $columns], function () use ($where, $columns) {
            return parent::findWhere($where, $columns);
        });
    }

    /**
     * Find data by Criteria
     *
     * @param CriteriaInterface $criteria
     *
     * @return mixed
     */
    public function getByCriteria(CriteriaInterface $criteria)
    {
        if (!$this->allowedCache('getByCriteria') || $this->isSkippedCache()) {
            return parent::getByCriteria($criteria);
        }

        return $this->getOrSetCache(['getByCriteria', $criteria], function () use ($criteria) {
            return parent::getByCriteria($criteria);
        });
    }
}
