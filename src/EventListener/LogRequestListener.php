<?php

namespace App\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class LogRequestListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        //dd(__DIR__);
        $request = $event->getRequest();
        $file = __DIR__."/text.log";
        $c = file_get_contents($file);
        $log = (new \DateTime())->format('Y-m-d').":".$request->getRequestUri()."\n";
        $c .= $log;
        file_put_contents($file, $c);

        $this->logger->info($log);
    }
}
