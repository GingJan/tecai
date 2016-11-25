<?php
namespace tecai\Cache\Operations\String;

use tecai\Cache\Operations\Operation;
use Illuminate\Contracts\Cache\Repository;

class IlluminateRepositoryAdapter extends Operation
{
    /**
     * @var Repository
     */
    protected $illuminateCacheRepository;

    public function __construct()
    {
        parent::__construct();
        $this->illuminateCacheRepository = app(Repository::class);
    }

    public function clean()
    {
        $this->connection->del($this->key);
    }

    public function exists()
    {
        return $this->illuminateCacheRepository->has($this->key);
    }

    public function set($value, $minutes = '')
    {
        empty($minutes) ?
            $this->illuminateCacheRepository->forever($this->key, $value) : $this->illuminateCacheRepository->put($this->key, $value, $minutes);
    }

    public function get($default = '')
    {
        return $this->illuminateCacheRepository->get($this->key, $default);
    }

    public function setIfNotExists($value, $minutes)
    {
        $this->illuminateCacheRepository->add($this->key, $value, $minutes);
    }

    public function remeber()
    {

    }

    public function forget()
    {

    }

    public function pull()
    {
        return $this->illuminateCacheRepository->pull($this->key, '');
    }
}
