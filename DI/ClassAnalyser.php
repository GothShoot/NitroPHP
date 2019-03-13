<?php

namespace NitroPHP\DI;

/**
 * Class used to analyse Class for various infos
 */
class ClassAnalyser
{

    /**
     * Get class dependencies
     *
     * @param string $class
     * @return array
     */
    public static function getDependencies(string $class):array
    {
        $reflector = new \ReflectionClass($class);

		if (!$reflector->isInstantiable()) {
			throw new Exception("Class {$class} is not instantiable");
		}

		$constructor = $reflector->getConstructor();

		if (is_null($constructor)) {
			return $reflector->newInstance();	
		}

        $parameters = $constructor->getParameters();
        
        $dependencies = [];
		foreach ($parameters as $parameter) {
			$dependency = $parameter->getClass();
			if ($dependency === null) {
				if ($parameter->isDefaultValueAvailable()) {
					$dependencies[] = $parameter->getDefaultValue();
				}
				else {
					throw new Exception("Can not resolve class dependency {$parameter->name}");
				}
			}
			else {
				$dependencies[] = $dependency;
			}
		}
		return $dependencies;
    }
}