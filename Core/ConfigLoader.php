<?php

namespace Core;

use Core\Singleton;
use Core\CacheAdapter;

class ConfigLoader extends Singleton
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
            $this->module = $this->listModule();
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

    private function listModule():array
    {
        $cacheAdapter = CacheAdapter::getInstance();
        $type = $cacheAdapter->cacheExists('App/module');
        if( $type === null || $this->appconf['dev'] ){
            $raw_files = scandir( ROOT_DIR.'/Module/' );
            $files = [];
            foreach($raw_files as $file){
                if ($file != '.' && $file != '..') {
                    $files[$file] = $this->loadJsonConfig(ROOT_DIR.'/Module/'.$file.'/Config/');
                    $files[$file]['file'] = $file;
                }
            }
            $type = $cacheAdapter->setCache('App/module', $files);
        }
        return $cacheAdapter->getCache('App/module', $type);
    }
}