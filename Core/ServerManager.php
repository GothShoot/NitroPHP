<?php

namespace PlumeSolution\NitroPHP\Core;

use App\Kernel;
use PlumeSolution\NitroPHP\Threads\ServerThread;

/**
 * Class ServerManager
 * @package PlumeSolution\NitroPHP\Core
 */
class ServerManager
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var ServerThread
     */
    private $serverThread;

    /**
     * @var LoopManager
     */
    private $loopManager;

    /**
     * ServerManager constructor.
     */
    public function __construct()
    {
        $this->kernel = new Kernel();
        $this->loopManager = new LoopManager($this->kernel);
        $this->serverThread = new ServerThread($this->kernel, $this->loopManager);
        $this->run();
    }

    /**
     * Wait for command in CLI
     */
    public function wait()
    {
        $resSTDIN=fopen("php://stdin","r");
        echo("Type anything.");
        $strChar = stream_get_contents($resSTDIN, 1);
        switch ($strChar)
        {
            case 'stop':
                echo("\nYou typed: ".$strChar.". stopping server\n\n");
                $this->stop();
                break;
            case 'restart':
                echo("\nYou typed: ".$strChar.". restart server\n\n");
                $this->reboot();
                break;
        }
        fclose($resSTDIN);
    }

    /**
     * Run the server thread
     */
    public function run()
    {
        if($this->serverThread->start())
        {
            $this->wait();
        }
        else
        {
            die ('Unable to start server thread');
        }

    }

    /**
     * Reboot app
     */
    public function reboot()
    {
        $this->kernel->reboot();
        $this->serverThread->kill() && $this->run();
    }

    /**
     * Stop the app
     */
    public function stop()
    {
        $this->serverThread->kill();
        die('Server is stopped, good bye :)');
    }
}