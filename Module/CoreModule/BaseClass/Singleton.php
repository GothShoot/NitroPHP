<?php

namespace Module\CoreModule\BaseClass;

class Singleton
{
    protected static $instances = [];
    
    final public function __clone()
    {
        trigger_error("Le clonage n'est pas autorisé.", E_USER_ERROR);
    }
    
    final public static function getInstance()
    {
        $c = get_called_class();
       
        if(!isset(static::$instances[$c]))
        {
            static::$instances[$c] = new $c;
        }
        return static::$instances[$c];
    }
}