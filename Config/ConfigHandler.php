<?php

namespace NitroPHP\Config;

use Alzundaz\NitroPHP\BaseClass\Singleton;

/**
 * Read and set config on app or modules
 */
class ConfigHandler extends Singleton
{

    public static function getInstance()
    {
        if(!isset(static::$instances['config.handler']))
        {
            static::$instances['config.handler'] = new self;
        }
        return static::$instances['config.handler'];
    }

    public function hasConfig(string $path):bool
    {
        if(file_exists($path)) return true;
        return false;
    }

    /**
     * Load single/multiple json config file
     *
     * @param string $path
     * @param string $file if not given all json in path be loaded
     * @return array $configs
     */
    public function getConfig(string $path, string $file = null):array
    {
        if( isset($file) ) {
            return json_decode(file_get_contents($path . $file), true);
        }
        $raw_files = scandir($path);
        $files = [];
        foreach($raw_files as $file){
            if (pathinfo($path . $file, PATHINFO_EXTENSION) == 'json') $files[] = $path . $file;
        }
        $configs = [];
        foreach($files as $file) {
            $configs = array_merge($configs, json_decode(file_get_contents($file), true));
        }
        return $configs;
    }

    /**
     * Set Config in json file
     *
     * @param string $path
     * @param array $data
     * @return void
     */
    public function setConfig(string $path, array $data)
    {
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}