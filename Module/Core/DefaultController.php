<?php

namespace Module\Core;

use Core\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        return $this->render('@Core/index.html.twig');
    }
}