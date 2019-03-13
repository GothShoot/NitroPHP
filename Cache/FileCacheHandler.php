<?php

namespace NitroPHP\Cache;

use Alzundaz\NitroPHP\Cache\CacheHandler;
use Alzundaz\NitroPHP\Cache\CacheInterface;

class FileCacheHandler extends CacheHandler implements CacheInterface
{
    /**
     * Detect if cache entry exist
     *
     * @param string $file file path like var/cache/$file
     * @return string|null return null on inexists, or return true
     */
    public function hasCache(string $key):?string
    {
        if( !file_exists( (ROOT_DIR.'/Var/Cache/') ) ){mkdir(ROOT_DIR.'/Var/Cache/', 0775, true);}
        if( file_exists( ROOT_DIR.'/Var/Cache/'.$key ) ){return true;}
        return null;
    }

    public function setCache(string $key, $data):?string
    {
        if( !file_exists( (ROOT_DIR.'/Var/Cache/') ) ){mkdir(ROOT_DIR.'/Var/Cache/', 0775, true);}
        switch ( gettype($data) ) {
            case 'array':
                if(file_put_contents(ROOT_DIR.'/Var/Cache/'.$key, json_encode($data))) return true;
                break;
            case 'object':
                if(file_put_contents(ROOT_DIR.'/Var/Cache/'.$key, serialize($data))) return true;
                break;
        }
        return null;
        
    }

    public function getCache(string $key)
    {
        if( $this->hasCache($key) ) {
            $result = json_decode(file_get_contents(ROOT_DIR.'/Var/Cache/'.$key), true);
            if( $result === null ) {
                $result = unserialize(file_get_contents(ROOT_DIR.'/Var/Cache/'.$key));
                if( $result === false ) return null;
            }
            return $result;
        }
        return null;
    }
}