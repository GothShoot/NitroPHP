<?php

namespace Alzundaz\NitroPHP\Services;

use Alzundaz\NitroPHP\BaseClass\Singleton;
use Alzundaz\NitroPHP\Services\CacheHandler;
use Alzundaz\ModuleManager\Services\ModuleManager;

class ConfigHandler extends Singleton
{
    private $appconf;

    private $module;

    /**
     * automaticaly register appconf and modules on singleton 
     */
    public function __construct()
    {
        $this->appconf = $this->loadJsonConfig(ROOT_DIR.'/Config/', 'app.json');
        if( $this->appconf['dev'] || !file_exists(ROOT_DIR.'/Config/module.json') ) $this->module = ModuleManager::GetInstance()->listInstalledModule();
        $this->loadJsonConfig(ROOT_DIR.'/Config/', 'module.json');
    }

    /**
     * Getters for app config
     *
     * @return array $this->appConf
     */
    public function getAppConf():array
    {
        // if(!$this->appconf){
        //     $this->appconf = $this->loadJsonConfig(ROOT_DIR.'/Config/', 'app.json');
        // }
        return $this->appconf;
    }

    /**
     * Getters for modules
     *
     * @return array $this->module
     */
    public function getModule():array
    {
        // if(!$this->module){
        //     if( $this->appconf['dev'] || !file_exists(ROOT_DIR.'/Config/module.json') ) $this->module = ModuleManager::GetInstance()->listInstalledModule();
        //     $this->loadJsonConfig(ROOT_DIR.'/Config/', 'module.json');
        // }
        return $this->module;
    }

    /**
     * Load single/multiple json config file
     *
     * @param string $path
     * @param string $file if not given all json in path be loaded
     * @return array $configs
     */
    public function loadJsonConfig(string $path, string $file = null):array
    {
        if( isset($file) ) {
            var_dump($path);
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