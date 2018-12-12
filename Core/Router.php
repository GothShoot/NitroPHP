<?php

use ConfigLoader;

class Router
{
    private function parse($url, $request)
    {
        $routes = ConfigLoader::loadConfig('Routes');
        foreach($routes as $route){
            if($route == $url) {
                return $route->controller;
            }
            header('Location: /index.php/erreur');
        }
        header('Location: /index.php/erreur');
    }
}
