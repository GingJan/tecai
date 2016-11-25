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
     * @return mixed
     */
    public function set($values);

    /**
     * @param string $values
     * @return mixed
     */
    public function get($values);

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  string $value
     * @param  \Closure  $callback
     * @param  \DateTime|int  $minutes
     * @return mixed
     */
    public function remember($value, \Closure $callback, $minutes = null);

    /**
     * @return mixed
     */
    public function clean();

}
