<?php
namespace tecai\Cache\Operations;

interface OperationInterface
{
    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key);

    /**
     * @param mixed $values
     * @param int $minutes
     * @return mixed
     */
    public function set($values, $minutes = null);

    /**
     * @return mixed
     */
    public function get();

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  \Closure  $callback
     * @param  \DateTime|int  $minutes
     * @return mixed
     */
    public function getOrCache(\Closure $callback, $minutes = null);

    /**
     * @return mixed
     */
    public function clean();

    public function setIfNotExists($value, $minutes);

}
