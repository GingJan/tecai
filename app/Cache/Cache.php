<?php
namespace tecai\Cache;

use tecai\Cache\Operations\OperationInterface;

class Cache
{
    /**
     * @var array
     */
    protected static $structures = [];

    public function __construct()
    {
        $structures = config('cache.structures', '');
        if (!empty($structures)) {

            foreach ($structures as $structure => $concrete) {
                $structureObject = app($structure);
                if ( $structureObject instanceof OperationInterface) {
                    static::$structures[strtolower($structure)] = $structureObject;
                }
            }
        }
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