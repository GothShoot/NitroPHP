<?php
class Controller
{
    public function __construct()
    {
        global $twig;
        $twig = Kernel::loadTwig();
    }
    public function render($view, $param=[])
    {
        return $twig->render($view, $param);
    }
    public function renderblock($view, $param=[], $block)
    {
        return $twig->render($view, $param);
    }
}