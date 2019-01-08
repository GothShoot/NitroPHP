<?php

namespace Module\CoreModule\Controller;

use Core\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        $this->render('@CoreModule/index.html.twig');
    }
}