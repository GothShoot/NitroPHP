<?php

namespace NitroPHP\Cache;

use Alzundaz\NitroPHP\BaseClass\Singleton;
use Alzundaz\NitroPHP\Cache\ApcuCacheHandler;
use Alzundaz\NitroPHP\Cache\FileCacheHandler;
use Alzundaz\NitroPHP\Config\ParametersBag;

class CacheHandler extends Singleton
{
    public static function getInstance()
    {
        if(!isset(static::$instances['cache.handler']))
        {
            $cachemode = ParametersBag::getInstance()->get('app')['cachemode'];
            static::$instances['cache.handler'] = ($cachemode == 'file' ? new FileCacheHandler : new ApcuCacheHandler);
        }
        return static::$instances['cache.handler'];
    }    
}