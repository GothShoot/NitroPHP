<?php

namespace Alzundaz\NitroPHP\BaseClass;

/**
 * Singleton/Multiton Class
 */
class Singleton
{
    /**
     * Property used to store instances of classes
     *
     * @var array $instances
     */
    protected static $instances = [];
    
    /**
     * Default cloning protection, you can overide this
     *
     * @return void
     */
    public function __clone()
    {
        trigger_error("Le clonage n'est pas autorisé.", E_USER_ERROR);
    }
    
    /**
     * Singleton instance getters, use Container for multiton
     *
     * @return void
     */
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