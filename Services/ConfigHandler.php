<?php

namespace Alzundaz\NitroPHP\Services;

use Alzundaz\NitroPHP\BaseClass\Singleton;
use Alzundaz\NitroPHP\Services\CacheHandler;
use Alzundaz\ModuleManager\Services\ModuleManager;

class ConfigHandler extends Singleton
{
    private $appconf;

    private $module;

    public function getAppConf():array
    {
        if(!$this->appconf){
            $this->appconf = $this->loadJsonConfig(ROOT_DIR.'/Config/', 'app.json');
        }
        return $this->appconf;
    }

    public function getModule():array
    {
        if(!$this->module){
            if($this->appconf['dev']) $this->module = ModuleManager::GetInstance()->listInstaledModule();
            $this->loadJsonConfig(ROOT_DIR.'/Config/', 'module.json');
        }
        return $this->module;
    }

    public function loadJsonConfig(string $path, string $file = null):array
    {
        if($file) {
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

    public function setConfig(string $path, array $data)
    {
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}