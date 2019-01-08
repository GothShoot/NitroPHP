<?php
    $start = microtime(true);
    if(!defined ( 'ROOT_DIR' )){
        define('ROOT_DIR', __DIR__.'/..');
        define('WEBROOT_DIR', ROOT_DIR.'/Public');
    }
    require_once ROOT_DIR.'/vendor/autoload.php';
    use Core\Profiler;
    use Core\Router;
    $router=new Router();
    $router->getController();
    $end = microtime(true);
    Profiler::getInstance()->setTime(['name'=>'App', 'start'=>$start, 'end'=>$end]);
    Profiler::getInstance()->profileBar();
?>