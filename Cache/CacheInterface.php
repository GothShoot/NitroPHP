<?php

namespace NitroPHP\Cache;

interface CacheInterface
{
    /**
     * Check if cache exists and return is type if true, null if false
     *
     * @param string $key
     * @return bool
     */
    public function hasCache(string $key):bool;

    /**
     * Register an entry in cache
     *
     * @param string $key
     * @param mixed $data
     * @return void
     */
    public function setCache(string $key, $data):void;


    /**
     * get an entry in cache
     *
     * @param string $key
     * @return mixed data
     */
    public function getCache(string $key);
}