<?php

namespace NitroPHP\BaseClass;

/**
 * Singleton/Multiton Class
 */
class Singleton
{
    /**
     * Property used to store instances of classes and services
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
    public static function getInstance()
    {
        if(isset(static::$serviceName)){
            $c = static::$serviceName;
        } else {
            $c = static::class;
        }
        
        if(!isset(self::$instances[$c]))
        {
            self::$instances[$c] = new static;
        }
        return self::$instances[$c];
    }
}