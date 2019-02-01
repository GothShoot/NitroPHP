<?php

namespace Alzundaz\NitroPHP\BaseClass;

class Request
{
    private $post;
    private $get;
    private $files;
    private $server;
    private $cookie;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
    }

    public function isPost():bool
    {
        if( count($this->post) > 0 ) return true;
        return false;
    }

    public function isGet():bool
    {
        if( count($this->get) > 0 ) return true;
        return false;
    }

    public function haveFiles():bool
    {
        if( count($this->files) > 0 ) return true;
        return false;
    }
    
    // Getters

    /**
     * Get the value of post
     */ 
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get the value of get
     */ 
    public function getGet()
    {
        return $this->get;
    }

    /**
     * Get the value of files
     */ 
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get the value of server
     */ 
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get the value of cookie
     */ 
    public function getCookie()
    {
        return $this->cookie;
    }
}