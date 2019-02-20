<?php

namespace Alzundaz\NitroPHP\DI;

use Alzundaz\NitroPHP\BaseClass\Singleton;

class ServicesContainer extends Singleton
{
	/**
     * @param       $abstract
     * @param array $parameters
     *
     * @return mixed|null|object
     */
	public function get($abstract, $parameters = [])
	{
		if (!isset(self::$instances[$abstract])) {
			$this->set($abstract);
		}
		return $this->resolve(self::$instances[$abstract], $parameters);
	}

	/**
	 * @param      $abstract
	 * @param null $concrete
	 */
	public function set($abstract, $concrete = NULL)
	{
		if ($concrete === NULL) {
			$concrete = $abstract;
		}
		self::$instances[$abstract] = $concrete;
	}
	
	/**
     * resolve single
     *
     * @param $concrete
     * @param $parameters
     *
     * @return mixed|object
     * @throws Exception
     */
	public function resolve($concrete, $parameters)
	{
		$reflector = new ReflectionClass($concrete);

		if (!$reflector->isInstantiable()) {
			throw new Exception("Class {$concrete} is not instantiable");
		}

		$constructor = $reflector->getConstructor();

		if (is_null($constructor)) {
			return $reflector->newInstance();	
		}

		$parameters = $constructor->getParameters();
		$dependencies = $this->getDependencies($parameters);

		return $reflector->newInstanceArgs($dependencies);
	}
	
	/**
     * get all dependencies resolved
     *
     * @param $parameters
     *
     * @return array
     * @throws Exception
     */
	public function getDependencies($parameters)
	{
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
				$dependencies[] = $this->get($dependency->name);
			}
		}
		return $dependencies;
	}
}




