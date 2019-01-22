<?php

namespace Module\CoreModule\BaseClass;

use Module\CoreModule\Services\ConfigLoader;
use Module\ViewModule\Services\TwigFactory;

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
            $this->twig =  TwigFactory::getTwigFactory()->getTwig();
        }
    }
    
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