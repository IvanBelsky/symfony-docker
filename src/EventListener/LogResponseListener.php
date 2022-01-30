<?php
/*My Ressponse
 */

namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\ResponseEvent;

class LogResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {

        $file = __DIR__."/text.log";
        $c = file_get_contents($file);
        $c .= $event->getResponse()->getDate()->format('Y-m-d').' New response'."\n";
        file_put_contents($file, $c);

    }

}