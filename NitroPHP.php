<?php

namespace NitroPHP;

use Alzundaz\NitroPHP\BaseClass\Singleton;
use Alzundaz\NitroPHP\Config\ConfigHandler;
use Alzundaz\NitroPHP\Config\ParametersBag;
use Alzundaz\NitroPHP\ModuleManager\ModuleManager;

/**
 * NitroPHP Kernel
 */
class NitroPHP extends Singleton
{
    /**
     * NitroPHP parameters bag
     *
     * @var ParametersBag
     */
    private $parametersBag;

    /**
     * NitroPHP config handler
     *
     * @var ConfigHandler
     */
    private $configHandler;

    /**
     * NitroPHP module manager
     *
     * @var ModuleManager
     */
    private $moduleManager;

    /**
     * NitroPHP pre init
     */
    public function __construct()
    {
        $this->parametersBag = ParametersBag::getInstance();
        $this->configHandler = ConfigHandler::getInstance();
        $this->moduleManager = ModuleManager::getInstance();
    }

    /**
     * Init framework and return instance of NitroPHP kernel
     *
     * @return NitroPHP
     */
    public static function init():self
    {
        $nitro = self::getInstance();

        return $nitro
            ->loadAppConfigs()
            ->loadModule()
            ->loadModulesConfigs()
            ->loadServices();
    }

    /**
     * Load app config
     *
     * @return self
     */
    public function loadAppConfig():self
    {
        $this->parametersBag->set('app', $this->configHandler->getConfig(ROOT_DIR.'/Config/', 'framework.json') );
        return $this;
    }

    /**
     * Load app modules
     *
     * @return self
     */
    public function loadModule():self
    {
        $this->moduleManager->getModule();
        return $this;
    }

    /**
     * Load modules config
     *
     * @return self
     */
    public function loadModulesConfigs():self
    {

        return $this;
    }

    /**
     * Load services from framework and modules
     *
     * @return self
     */
    public function loadServices():self
    {

        return $this;
    }
}