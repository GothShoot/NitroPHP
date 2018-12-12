<?php
define('ROOT_DIR', __DIR__.'/..');
define('WEBROOT_DIR', ROOT_DIR.'/Public');
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/Config/core.php';

class Kernel
{
    public function loadTwig($module)
    {
        if(!isset($twig))
        $loader = new Twig_Loader_Filesystem("/$module/view");
        $twig = new Twig_Environment($loader, array(
            'cache' => (CACHE_MODE ? false : "/Var/Cache/View/$module"),
            'auto_reload' => (MODE == 'DEV' ? true : false)
        ));
        $twig->addExtension(new Twig_Extension_Core());
        $twig->addExtension(new Twig_Extension_Escaper('html'));
        return $twig;
    }

    public function loadJsonConfigGroup($path, $file = null)
    {
        $path = ROOT_DIR .'/Config'. $path . '/';
        if($file) {
            return json_decode(file_get_contents($path . $file), true);
        }
        $raw_files = scandir($path);
        foreach($raw_files as $file){
            if (is_file($path . $file)) $files[] = $path . $file;
        }
        foreach($files as $file) {
            $configs = array_merge($configs, json_decode(file_get_contents($file[$o]), true));
        }
        return $configs;
    }
}