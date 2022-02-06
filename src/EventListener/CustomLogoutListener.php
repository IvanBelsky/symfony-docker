<?php
/*My CustomLogoutListener */

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class CustomLogoutListener
{

        /**
         * @param LogoutEvent $logoutEvent
         * @return void
         */
        #[NoReturn]
        public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $logoutEvent): void
    {
        $logoutEvent->setResponse(new RedirectResponse('/index', Response::HTTP_MOVED_PERMANENTLY));

        $data = $logoutEvent->getResponse()->getContent();
     //   dd($data);
        $file = '/text.log';
        $file = '/var/www/symfony/src/EventListener'.$file;
        $c = file_get_contents($file);
        $c .= '--LogOut -- '.(new \DateTime())->format('Y-m-d')."\n";
        file_put_contents($file, $c);
    }
}