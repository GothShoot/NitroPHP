<?php
    require( __DIR__.'/../Core/Kernel.php' );
    $kernel = new Kernel();
    use Module\Core\DefaultController;
    $instance = new DefaultController();
    print_r($instance->index());
?>