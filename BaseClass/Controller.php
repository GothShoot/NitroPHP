<?php

namespace Alzundaz\NitroPHP\BaseClass;

use Alzundaz\NitroPHP\Services\ConfigHandler;
use Alzundaz\View\Services\TwigFactory;

class Controller
{
    private $request;

    protected $appconf;

    protected $ConfigHandler;

    public function __construct()
    {
        $this->ConfigHandler = ConfigHandler::getInstance();
        $this->appconf = $this->ConfigHandler->getAppConf();
    }

    private function loadTwig()
    {
        return TwigFactory::getTwigFactory()->getTwig();
    }

    protected function getRequest():Request
    {
        if( !isset($this->request) ) $this->request = new Request();
        return $this->request;
    }
    
    protected function render(string $view, array $param=[])
    {
        echo $this->loadTwig()->render($view, $param);
    }

    protected function renderblock(string $view, array $param=[], string $block)
    {
        echo $this->loadTwig()->render($view, $param);
    }
}