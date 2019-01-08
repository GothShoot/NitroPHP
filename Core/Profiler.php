<?php

namespace Core;

use Core\Singleton;

class Profiler extends Singleton
{
    private $token;

    private $time = [];
    private $error = [];
    private $alert = [];
    private $dump = [];

    public function printProfile()
    {
        echo '<hr />timeline<pre>';
        print_r($this->time);
        echo '</pre><br />error<pre>';
        print_r($this->error);
        echo '</pre><br />alert<pre>';
        print_r($this->alert);
        echo '</pre><br />dump<pre>';
        print_r($this->dump);
        echo '</pre><hr /><a href=?profiletoken="'.$this->token.'">see more</a>';
    }

    public function profileBar()
    {
        echo '
            <hr>
            <style>
                .profileBar { padding: 3px; background-color: #6495ED; }
                .profileBar a { padding: 3px; color: #FFF; }
                .time-green { background-color: #32CD32; }
                .time-red { background-color: #FF4500; }
            </style>
            <div class="profileBar">
            <a class="time-'.($this->time[count($this->time)-1] < 150 ? 'green':'red' ).'" href="?token='. $this->token .'">'. $this->time[count($this->time)-1]['ExecutionTime'] .'</a>
            <a href="?token='. $this->token .'">erreur: '. count($this->error) .'</a>
            <a href="?token='. $this->token .'">dump: '. count($this->dump) .'</a>
            </div>
        ';
    }

// Getters and Setters
    public function getTime(?string $id = null):array
    {
        if(!$id)  {return $this->time;}
        return $this->time[$id];
    }

    public function setTime(array $data)
    {
        if(!isset($this->token)) {$this->token = time().'_'.rand(0, 20);}
        $data['id'] = count($this->time);
        $data['ExecutionTime'] = number_format((round( $data['end']-$data['start'], 3)* 1000) , 2 , "ms" , "s" );
        array_push($this->time, $data);
    }

    public function getError(?string $id = null):array
    {
        if(!$id)  {return $this->error;}
        return $this->error[$id];
    }

    public function setError(array $data)
    {
        $data['id'] = count($this->error);
        array_push($this->error, $data);
    }

    public function getAlert(?string $id = null):array
    {
        if(!$id)  {return $this->alert;}
        return $this->alert[$id];
    }

    public function setAlert(array $data)
    {
        $data['id'] = count($this->alert);
        array_push($this->alert, $data);
    }

    public function getDump(?string $id = null):array
    {
        if(!$id)  {return $this->dump;}
        return $this->dump[$id];
    }

    public function setDump(array $data)
    {
        $data['id'] = count($this->dump);
        array_push($this->dump, $data);
    }
}