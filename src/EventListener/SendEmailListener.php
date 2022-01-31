<?php

namespace App\EventListener;


use App\Events\SendEmailEvent;

class SendEmailListener
{
    public function onSendUserEmail(SendEmailEvent $event)
    {
        //dd(__DIR__);
        $id = $event->getUser()->getId();
        $message = $event->getMessage();
        $file = __DIR__."/text.log";
        $c = file_get_contents($file);
        $c .= (new \DateTime())->format('Y-m-d').":".$id.' : '. $message."\n";
        file_put_contents($file, $c);
    }

}