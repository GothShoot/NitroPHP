<?php

namespace NitroPHP\Config;

use Alzundaz\NitroPHP\BaseClass\Singleton;

/**
 * Parameters Container
 */
class ParametersBag extends Singleton
{
    /**
     * App parameters
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Get parameter
     *
     * @param string $key
     * @return array|null
     */
    public function get(string $key) : ?array
    {
        if ( key_exists($key, $this->parameters) ){
            return $this->parameters[$key]; 
        } else {
            throw new Exception('Unable to find '.$key.' parameter in bag');
        }
    }

    /**
     * Set parameter
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    public function set(string $key, array $data) : void
    {
        $this->parameters[$key] = $data;
    }


}