<?php
namespace tecai\Cache\Operations;

interface OperationInterface
{
    /**
     * @param string $key
     * @param int $minutes
     * @return $this
     */
    public function setKey($key, $minutes = null);

    /**
     * @param mixed $values
     * @return mixed
     */
    public function set($values);

    /**
     * @return mixed
     */
    public function get();

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param \Closure $callback
     * @return mixed
     */
    public function getOrCache(\Closure $callback);

    /**
     * @return mixed
     */
    public function clean();

    public function setIfNotExists($value);

}
