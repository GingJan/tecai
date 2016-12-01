<?php
namespace tecai\Cache\Operations\String;

use tecai\Cache\Operations\RedisOperation;

class RedisString extends RedisOperation
{
    /**
     * Clean the key.
     *
     * @return int
     */
    public function clean()
    {
        return $this->connection->del($this->key);
    }

    /**
     * Save the value and set expire.
     *
     * @param mixed $value
     * @return int|mixed
     */
    public function set($value)
    {
        $this->validity($value);
    }

    /**
     * @param string $value
     * @return int|mixed
     */
    protected function validity($value)
    {
        if ($this->minutes > 0) {
            return $this->connection->setex($this->key, $this->minutes * 60, $value);
        }

        return $this->connection->set($this->key, $value);
    }

    /**
     * Save the value if the key does not exist.
     *
     * @param $value
     */
    public function setIfNotExists($value)
    {
        if (!$this->connection->exists($this->key)) {
            $this->set($value);
        }
    }

    public function get()
    {
        return $this->connection->get($this->key);
    }

    public function getOrCache(\Closure $callback, $minutes = null)
    {
        if (!empty($res = $this->get($this->key))) {
            return $res;
        }

        $this->set($cache = $callback());

        return $cache;
    }

}