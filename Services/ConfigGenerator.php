<?php

namespace Alzundaz\NitroPHP\Services;

use Alzundaz\NitroPHP\Services\ConfigHandler;
use Alzundaz\NitroPHP\BaseClass\Singleton;

class ConfigGenerator extends Singleton
{
    /**
     * Generate Default config
     * @param $base base path to file you copy
     * @param $path path to file you generate
     * @return null
     */
    public function generateConfig(string $basePath, string $baseFile, string $path)
    {
        $configHandler = ConfigHandler::getInstance();
        $data = $configHandler->loadJsonConfig($basePath, $baseFile);
        $configHandler->setConfig($path, $data);
    }
}