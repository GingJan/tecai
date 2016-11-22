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

    public function exists()
    {
        return $this->illuminateCacheRepository->has($this->key);
    }

    public function set($value, $minutes = 30)
    {
        $this->put($value, $minutes);
    }

    public function get($default = '')
    {
        return $this->illuminateCacheRepository->get($this->key, $default);
    }

    public function pull()
    {
        return $this->illuminateCacheRepository->pull($this->key, '');
    }

    public function put($value, $minutes = 30)
    {
        $this->illuminateCacheRepository->put($this->key, $value, $minutes);
    }

    public function add()
    {

    }

    public function forget()
    {

    }
}
