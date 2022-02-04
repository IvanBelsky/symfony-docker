<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
class LogIfAdminRouteSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::CONTROLLER=> ['logAdminLogin', 1],
            KernelEvents::CONTROLLER_ARGUMENTS=>['arguments',0],
                ];

        // TODO: Implement getSubscribedEvents() method.
    }

    public function logAdminLogin(ControllerEvent $event)
    {
        $file = '/text.log';
        $file = '/var/www/symfony/src/EventListener'.$file;
        $c = file_get_contents($file);
        $c .= 'Admin request --- Controller '.(new \DateTime())->format('Y-m-d')."\n";
        file_put_contents($file, $c);
    }


    public function arguments(ControllerArgumentsEvent $event)
    {
        $file = '/text.log';
        $file = '/var/www/symfony/src/EventListener'.$file;
        $c = file_get_contents($file);
        $c .= 'Admin request --- ControllerArgumentsEvent '.(new \DateTime())->format('Y-m-d')."\n";
        file_put_contents($file, $c);
    }

}