<?php


namespace App\EventSubscriber;


use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LogIfAdminRouteSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * The code must not depend on runtime state as it will only be called at compile time.
     * All logic depending on runtime state must be put into the individual methods handling the events.
     *
     * @return array<string, mixed> The event names to listen to
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::CONTROLLER=> ['logAdminLogin', 1],
            KernelEvents::CONTROLLER_ARGUMENTS=>['arguments',0]
        ];

        // TODO: Implement getSubscribedEvents() method.
    }

    public function logAdminLogin(ControllerEvent $event)
    {
       // dd(__DIR__);
        $controller = $event->getController();
        $st = $controller[0]; // $st2 = $st[0];
     //   dd($st);
        $file = '/text.log';
        $file = '/var/www/symfony/src/EventListener'.$file;
        $c = file_get_contents($file);
        $c .= 'Admin request --- Controller '.(new \DateTime())->format('Y-m-d')."\n";
        file_put_contents($file, $c);
    }


    public function arguments(ControllerArgumentsEvent $event)
    {
        // dd(__DIR__);
        $controller = $event->getArguments();
        $st = $controller[0]; // $st2 = $st[0];
     //   dd($st);
        $file = '/text.log';
        $file = '/var/www/symfony/src/EventListener'.$file;
        $c = file_get_contents($file);
        $c .= 'Admin request --- ControllerArgumentsEvent '.(new \DateTime())->format('Y-m-d')."\n";
        file_put_contents($file, $c);
    }

}