<?php
namespace tecai\Cache\Facades;

use Illuminate\Support\Facades\Facade;

class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tecai.cache';
    }
}