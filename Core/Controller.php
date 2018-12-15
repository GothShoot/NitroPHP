<?php

namespace Core;

class Controller
{
    public function __construct()
    {
        global $kernel;
        $this->twig = $kernel->loadTwig();
    }
    public function render($view, $param=[])
    {
        return $this->twig->render($view, $param);
    }
    public function renderblock($view, $param=[], $block)
    {
        return $this->twig->render($view, $param);
    }
}