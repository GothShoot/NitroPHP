<?php

namespace NitroPHP\Cache;

use Alzundaz\NitroPHP\Cache\CacheHandler;
use Alzundaz\NitroPHP\Cache\CacheInterface;

class ApcuCacheHandler extends CacheHandler implements CacheInterface
{
    public function hasCache($key)
    {
        return apcu_exists($key);
    }

    public function getCache($key)
    {
        //return apcu_exists($key);
        if ( apcu_exists($key) )
        {
            return apcu_fetch($key);
        }
        else
        {
            throw new \Exception("Invalid cache key $key requested.");
        }
    }

    // ***** Set or update cache entry methode *****
    public function setCache($key, $data)
    {
        if ( apcu_exists($key) )
        {
            if ( !apcu_store($key, $data) )
            {
                throw new \Exception("Unable to store $key value.");
            }
        }
        else
        { 
            if ( !apcu_add($key, $data) )
            {
                throw new \Exception("Unable to add $key value.");
            }
        }
    }
}