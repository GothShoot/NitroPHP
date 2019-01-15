<?php
if(!defined ( 'ROOT_DIR' )){
    define('ROOT_DIR', __DIR__.'/..');
    define('WEBROOT_DIR', ROOT_DIR.'/Public');
}
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/Config/core.php';

class Kernel
{
    public function loadTwig()
    {
        if(isset($twig) == false){
            $loader = new Twig_Loader_Filesystem();
            $loader->addPath(ROOT_DIR.'/Module/Core/View', 'Core');
            $twig = new Twig_Environment($loader, array(
                'cache' => (CACHE_MODE ? ROOT_DIR.'/Var/Cache/View' : false),
                'auto_reload' => (MODE == 'DEV' ? true : false)
            ));
            // $twig->addExtension(new Twig_Extension_Core());
            // $twig->addExtension(new Twig_Extension_Escaper('html'));
            return $twig;
        }
        
    }

    public function loadJsonConfig($path, $file = null)
    {
        if($file) {
            return json_decode(file_get_contents($path . $file), true);
        }
        $raw_files = scandir($path);
        $files = [];
        foreach($raw_files as $file){
            if (is_file($path . $file)) $files[] = $path . $file;
        }
        $configs = [];
        foreach($files as $file) {
            $configs = array_merge($configs, json_decode(file_get_contents($file), true));
        }
        return $configs;
    }

    public function listModule($force = false)
    {
        if( !file_exists( (ROOT_DIR.'/Var/Cache/App') ) ){mkdir(ROOT_DIR.'/Var/Cache/App', 0775, true);}
        if( !file_exists(ROOT_DIR.'/Var/Cache/App/module.cache') || $force ){
            $raw_files = scandir( ROOT_DIR.'/Module/' );
            $files = [];
            foreach($raw_files as $file){
                if ($file != '.' && $file != '..') { $files[] = $file; }
            }
            if($force || MODE == 'DEV'){unlink(ROOT_DIR.'/Var/Cache/App/module.cache');}
            file_put_contents(ROOT_DIR.'/Var/Cache/App/module.cache', serialize($files));
        }
        return unserialize(file_get_contents(ROOT_DIR.'/Var/Cache/App/module.cache'));
    }

    public function loadRoute($force = false)
    {
        if( !file_exists( (ROOT_DIR.'/Var/Cache/App') ) ){mkdir(ROOT_DIR.'/Var/Cache/App', 0775, true);}
        if( !file_exists(ROOT_DIR.'/Var/Cache/App/route.cache') || $force ){
            $modules = self::listModule();
            $routes = [];
            foreach($modules as $module){
                $routes = array_merge($routes, self::loadJsonConfig(ROOT_DIR.'/Module/'.$module.'/Config/Routes/'));
            }
            return $routes;
            if($force || MODE == 'DEV'){unlink(ROOT_DIR.'/Var/Cache/App/route.cache');}
            file_put_contents(ROOT_DIR.'/Var/Cache/App/route.cache', serialize($routes));
        }
        return unserialize(file_get_contents(ROOT_DIR.'/Var/Cache/App/route.cache'));
    }
}