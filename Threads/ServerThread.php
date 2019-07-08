<?php


namespace PlumeSolution\NitroPHP\Threads;

use App\Kernel;
use Nyholm\Psr7\Factory\Psr17Factory;
use PlumeSolution\NitroPHP\Core\LoopManager;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/**
 * Class ServerThread
 * @package PlumeSolution\NitroPHP\Threads
 */
class ServerThread extends \Thread
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var LoopManager
     */
    private $loopManager;

    /**
     * ServerThread constructor.
     * @param Kernel $kernel
     * @param LoopManager $loopManager
     */
    public function __construct(Kernel $kernel, LoopManager $loopManager)
    {
        $this->kernel = $kernel;
        $this->loopManager = $loopManager;
    }

    /**
     * Execution of the server in separated thread
     */
    public function run()
    {
        $kernel = $this->kernel;
        $psr17Factory = new Psr17Factory();
        $httpFoundationFactory = new HttpFoundationFactory();
        $psr7Factory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        // Callback for the loop
        $callback = function(Psr\Http\Message\ServerRequestInterface $request) use ($kernel, $httpFoundationFactory, $psr7Factory)
        {
            $kernel->incrementCount();
            try
            {
                // Convert the Psr Request to Symfony Request
                $symfonyRequest =  $httpFoundationFactory->createRequest($request);
                // Track request count per running instance of kernel
                $symfonyRequest->attributes->set('count', $kernel->getCount());
                $response = $kernel->handle($symfonyRequest);
            }
            catch (\Throwable $e)
            {
                return new React\Http\Response(
                    500,
                    ['Content-Type' => 'text/plain'],
                    $e->getMessage()
                );
            }
            // Convert the Symfony response to Psr response
            return $psr7Factory->createResponse($response);
        };

        $loopManager = $this->loopManager;
        $loop = $loopManager->create($callback);
        $loop->run();
    }

    /**
     * Useless function used in pthreads v2, be removed when v3 is supported (php 7.3 build)
     */
    public function setGarbage()
    {
        // TODO: Remove setGarbage method when pthreads is up to date
    }
}