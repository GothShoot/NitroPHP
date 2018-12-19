<?php

namespace Module\Core;

class CoreModule
{
    private $modpath = ROOT_DIR.'/Module/Core/';
    public function injectConfig()
    {
        global $kernel;
        return $kernel->loadJsonConfig($modpath.'Config');

    }

    public function injectRoute()
    {
        global $kernel;
        return $kernel->loadJsonConfig($modpath.'Config/Route');

    }

    public function injectEntitys()
    {
        global $kernel;
        return $kernel->loadJsonConfig($modpath.'Config/Entitys');
    }
}