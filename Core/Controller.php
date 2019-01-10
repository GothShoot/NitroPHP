<?php

namespace Core;

use Core\ConfigLoader;
use Twig_Loader_Filesystem;
use Twig_Environment;


class Controller
{
    private static $_instance;

    private $twig;

    protected $appconf;

    protected $configLoader;

    public function __construct()
    {
        $this->configLoader = ConfigLoader::getInstance();
        $this->appconf = $this->configLoader->getAppConf();
    }

    private function __clone()
    {
        trigger_error("Le clonage n'est pas autorisé.", E_USER_ERROR);
    }

    public static function getInstance() {
        if (!(static::$_instance instanceof static)) {static::$_instance = new self();}
        return static::$_instance;
    }

    private function loadTwig()
    {
        if(!isset($this->twig)){
            if( !file_exists(ROOT_DIR.'/Var/Cache/App/twig.cache') || $this->appconf['dev'] ){
                $loader = new Twig_Loader_Filesystem();
                foreach($this->configLoader->listModule() as $module){
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
                file_put_contents(ROOT_DIR.'/Var/Cache/App/twig.cache', serialize($twig));
            }
            $this->twig =  unserialize(file_get_contents(ROOT_DIR.'/Var/Cache/App/twig.cache'));
        }
    }

    /**
     * 
     * @param $view the view you want to display
     * 
     * @param $param value you want to access in view
     * 
     */
    protected function render(string $view, array $param=[])
    {
        $this->loadTwig();
        echo $this->twig->render($view, $param);
    }

    protected function renderblock(string $view, array $param=[], string $block)
    {
        $this->loadTwig();
        echo $this->twig->render($view, $param);
    }
}