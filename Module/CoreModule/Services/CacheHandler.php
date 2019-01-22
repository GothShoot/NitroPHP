<?php

namespace Module\CoreModule\Services;

use Module\CoreModule\BaseClass\Singleton;

class CacheHandler extends Singleton // implements SerializedCacheHandler, JsonCacheHandler
{
    public function cacheExists(string $file):?string
    {
        $directory = explode('/', $file)[0];
        if( !file_exists( (ROOT_DIR.'/Var/Cache/'.$directory) ) ){mkdir(ROOT_DIR.'/Var/Cache/'.$directory, 0775, true);}
        if( file_exists( ROOT_DIR.'/Var/Cache/'.$file.'.json' ) ){return 'json';}
        if( file_exists( ROOT_DIR.'/Var/Cache/'.$file.'.cache' ) ){return 'object';}
        return null;
    }

    public function setCache(string $file, $data):?string
    {
        $directory = explode('/', $file)[0];
        $type = gettype($data);
        if( !file_exists( (ROOT_DIR.'/Var/Cache/'.$directory) ) ){mkdir(ROOT_DIR.'/Var/Cache/'.$directory, 0775, true);}
        switch ($type) {
            case 'array':
                return JsonCacheHandler::setCache($file, $data);
                break;
            case 'object':
                return SerializedCacheHandler::setCache($file, $data);
                break;
            default:
                return null;
            break;
        }
        
    }

    public function getCache(string $file, string $type)
    {
        switch ($type) {
            case 'json':
                return JsonCacheHandler::getCache($file);
                break;
            case 'object':
                return SerializedCacheHandler::getCache($file);
                break;
        }
        return null;
    }
}

class SerializedCacheHandler
{
    public static function setCache(string $file, object $data):?string
    {
        if(file_put_contents(ROOT_DIR.'/Var/Cache/'.$file.'.cache', serialize($data))) return 'object';
        return null;
    }

    public static function getCache(string $file):?object
    {
        if(file_exists(ROOT_DIR.'/Var/Cache/'.$file.'.cache') ){
            return unserialize(file_get_contents(ROOT_DIR.'/Var/Cache/'.$file.'.cache'));
        }
        return null;
    }
}

class JsonCacheHandler
{
    public static function setCache(string $file, array $data):?string
    {
        if(file_put_contents(ROOT_DIR.'/Var/Cache/'.$file.'.json', json_encode($data))) return 'json';
        return null;
    }

    public static function getCache(string $file):?array
    {
        if(file_exists(ROOT_DIR.'/Var/Cache/'.$file.'.json') ){
            $result = json_decode(file_get_contents(ROOT_DIR.'/Var/Cache/'.$file.'.json'), true);
            return $result;
        }
        return null;
    }
}