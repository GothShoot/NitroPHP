<?php

namespace NitroPHP\ModuleManager;

use Alzundaz\NitroPHP\BaseClass\Singleton;
use Alzundaz\NitroPHP\Config\ParametersBag;
use Alzundaz\NitroPHP\Services\ConfigGenerator;
use Alzundaz\NitroPHP\Services\ConfigHandler;

class ModuleManager extends Singleton
{
    /**
     * Service name for this class
     *
     * @var string
     */
    protected static $serviceName = 'module.manager';

    protected static $serviceDeps = [
        'NitroPHP\Config\ParametersBag'=>'namespace',
        'NitroPHP\Config\ConfigGenerator'=>'namespace',
        
    ];

    /**
     * todo
     *
     * @return void
     */
    public function createModule(string $name, bool $enabled = false)
    {

    }

    /**
     * todo
     *
     * @param bool $enabled
     * @return void
     */
    public function addModule(string $name, bool $enabled = false)
    {

    }

    /**
     * Update module.json module list with installed modules
     *
     * @return void
     */
    public function getModule():void
    {
        $configHandler = ConfigHandler::getInstance();
        $parametersBag = ParametersBag::getInstance();
        if($parametersBag->get('app')['dev'] === true || !file_exists(ROOT_DIR.'/Config/module.json')) {
            if( !file_exists(ROOT_DIR.'/Config/module.json') ) ConfigGenerator::getInstance()->generateConfig(__DIR__.'/../Config/', 'module.json', ROOT_DIR.'/Config/module.json');
            $modules = $configHandler->getConfig(ROOT_DIR.'/Config/', 'module.json');
            $raw_files = scandir( ROOT_DIR.'/Module/' );
            foreach($raw_files as $file){
                if ($file != '.' && $file != '..') {
                    $data = $configHandler->getConfig(ROOT_DIR.'/Module/'.$file.'/Config/');
                    if ( !array_key_exists($file, $modules) ){
                        $data['enabled'] = false;
                        $data['path'] = 'Module/'.$file;
                        $modules[$file] = $data;
                    } else {
                        array_replace($modules[$file], $data);
                    }
                    ksort($modules[$file]);
                }
            }
            $configHandler->setConfig(ROOT_DIR.'/Config/module.json', $modules);
        }
        $parametersBag->set('modules', $configHandler->getConfig(ROOT_DIR.'/Config/module.json'));
    }
}