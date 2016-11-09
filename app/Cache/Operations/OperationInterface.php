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
}
