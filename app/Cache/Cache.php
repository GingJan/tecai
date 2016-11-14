<?php
namespace tecai\Cache;

use Illuminate\Contracts\Cache\Repository;
use tecai\Cache\Operations\OperationInterface;

class Cache
{
    /**
     * @var array
     */
    protected static $structures = [];

    /**
     * @var Repository
     */
    protected $cacheRepository;

    public function __construct()
    {
        $structures = config('cache.structures', '');
        $this->cacheRepository = app(Repository::class);
        if (!empty($structures)) {

            foreach ($structures as $structure => $concrete) {
                $structureObject = app($structure);
                if ( $structureObject instanceof OperationInterface) {
                    static::$structures[strtolower($structure)] = $structureObject;
                }
            }
        }
    }

    public function getCacheRepository()
    {
        return $this->cacheRepository;
    }

    public function __call($method, $params)
    {
        $structure = static::$structures[strtolower($method)];

        if (!isset($params[0])) {
            throw new \InvalidArgumentException('key not given');
        }

        $key = $params[0];
        if (!is_array($key) && !is_object($key)) {
            return $structure->setKey($key);
        } else {
            throw new \InvalidArgumentException('params invalid');
        }

    }
}