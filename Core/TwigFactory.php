<?php

namespace Core;

use Core\ConfigLoader;
use Core\CacheAdapter;
use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigFactory
{
    private $configLoader;

    private $cacheAdapter;

    private $appconf;

    public function __construct()
    {
        $this->configLoader = ConfigLoader::getInstance();
        $this->cacheAdapter = CacheAdapter::getInstance();
        $this->appconf = $this->configLoader->getAppConf();
    }

    public static function getTwigFactory()
    {
        return new self;
    }

    public function getTwig()
    {
        $type = $this->cacheAdapter->cacheExists('App/twig');
        if( !$type || $this->appconf['dev'] ){
            $loader = new Twig_Loader_Filesystem();
            foreach($this->configLoader->getModule() as $module){
                if($module['enabled']){
                    $loader->addPath(ROOT_DIR.'/Module/'.$module['name'].'/View', $module['name']);
                }
            }
            $twig = new Twig_Environment($loader, array(
                'cache' => ($this->appconf['cachemode'] ? ROOT_DIR.'/Var/Cache/View' : false),
                'auto_reload' => ($this->appconf['dev'])
            ));
            // $twig->addExtension(new Twig_Extension_Core());
            // $twig->addExtension(new Twig_Extension_Escaper('html'));
            // if($this->appconf['dev']){
            //     $profile = new Twig_Profiler_Profile();
            //     $twig->addExtension(new Twig_Extension_Profiler($profile));
            //     $dumper = new Twig_Profiler_Dumper_Text();
            // } else {
            //     $twig->addExtension(new Twig_Extension_Optimizer());
            // }
            $type = $this->cacheAdapter->setCache('App/twig', $twig);
        }
        return $this->cacheAdapter->getCache('App/twig', $type);
    }
}