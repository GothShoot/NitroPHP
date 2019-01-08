<?php

namespace Core;

use Core\Singleton;

class ConfigLoader extends Singleton
{
    private $appconf;

    public function getAppConf()
    {
        if(!$this->appconf){
            $this->appconf = $this->loadJsonConfig(ROOT_DIR.'/Config/', 'app.json');
        }
        return $this->appconf;
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

    public function listModule(bool $force = null):array
    {
        if( !file_exists( (ROOT_DIR.'/Var/Cache/App') ) ){mkdir(ROOT_DIR.'/Var/Cache/App', 0775, true);}
        if( !file_exists(ROOT_DIR.'/Var/Cache/App/module.json') || $force || $this->appconf['dev'] ){
            $raw_files = scandir( ROOT_DIR.'/Module/' );
            $files = [];
            foreach($raw_files as $file){
                if ($file != '.' && $file != '..') {
                    $files[$file] = $this->loadJsonConfig(ROOT_DIR.'/Module/'.$file.'/Config/');
                    $files[$file]['file'] = $file;
                }
            }
            file_put_contents(ROOT_DIR.'/Var/Cache/App/module.json', json_encode($files));
        }
        return json_decode(file_get_contents(ROOT_DIR.'/Var/Cache/App/module.json'), true);
    }
}