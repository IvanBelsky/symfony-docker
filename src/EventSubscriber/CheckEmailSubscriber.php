<?php

namespace App\EventSubscriber;


use App\Events\SendEmailEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckEmailSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents():array
{
        return [
            SendEmailEvent::SEND_EMAIL => ['checkEmailLog', 1],
        ];
}

    public function checkEmailLog(SendEmailEvent $event)
{
    $name = $event->getUser()->getFirstName();
    $email = $event->getUser()->getEmail();
  //  $message = $event->getMessage();
    $file = '/text.log';
    $file = '/var/www/symfony/src/EventListener'.$file;
    $c = file_get_contents($file);
    $c .= 'checkEmailLog: Надо проверить - User: '.$name.'  email: '.$email.'   '.(new \DateTime())->format('Y-m-d')."\n";
    file_put_contents($file, $c);
}


}