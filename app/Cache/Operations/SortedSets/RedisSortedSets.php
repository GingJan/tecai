<?php
namespace tecai\Cache\Operations\SortedSets;

use tecai\Cache\Operations\RedisOperation;

class RedisSortedSets extends RedisOperation
{
    public function set($value, $_ = null)
    {
        $count = func_num_args();

        if ($count > 1 && 0 == $count%2) {
            $value = [];
            $count = $count/2;
            while ($count) {
                $value[array_shift($value)] = array_shift($value);
                $count--;
            }
        }

        return $this->connection->zadd($this->key, $value);
    }

    public function get()
    {
//        return $this->connection->
    }

    public function getMemberByScore($score)
    {
        $this->getMembersBetweenScore($score, $score);
    }

    public function getMembersBetweenScore($min, $max, array $option = null)
    {
        return $this->connection->zrangebyscore($this->key, $min, $max, $option);
    }

    /**
     * @param string $member
     * @return string
     */
    public function getScoreByMember($member)
    {
        return $this->connection->zscore($this->key, $member);
    }

    public function add($value, $_ = null)
    {
        $count = func_num_args();

        if ($count > 1 && 0 == $count%2) {
            $value = [];
            $count = $count/2;
            while ($count) {
                $value[array_shift($value)] = array_shift($value);
                $count--;
            }
        }

        return $this->connection->zadd($this->key, $value);
    }
}