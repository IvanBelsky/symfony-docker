<?php

namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\RequestEvent;

class LogRequestListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        //dd(__DIR__);
        $request = $event->getRequest();
        $file = __DIR__."/text.log";
        $c = file_get_contents($file);
        $c .= (new \DateTime())->format('Y-m-d').":".$request->getRequestUri()."\n";
        file_put_contents($file, $c);
    }
}
