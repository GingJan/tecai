<?php
namespace tecai\Cache\Operations;

use Illuminate\Contracts\Cache\Store;
use Predis\ClientInterface;

abstract class Operation implements OperationInterface
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

    public function __construct()
    {
        $prefix = config('cache.prefix');
        $this->prefix = !empty($prefix) ? $prefix . ':' : '';
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

    /**
     * @param mixed $values
     * @return mixed
     */
    abstract public function set($values);

    /**
     * @param string $values
     * @return mixed
     */
    abstract public function get($values);
}