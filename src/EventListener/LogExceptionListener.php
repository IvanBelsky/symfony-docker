<?php
/*My handler some ExceptionEvent */

namespace App\EventListener;

use App\Controller\DefaultController;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class LogExceptionListener
{
 /*   private $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function getContainer():?Container{
        return $this->container;
    }
*/
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if($exception instanceof NotFoundHttpException){
            /*       $path = $this->getContainer()->get('router')->generate("frontend_404");
            $response = new RedirectResponse($path);
            $event->setResponse($response);
    */

       //    $response = new RedirectResponse('/index');
            $st = 'Страница не найдена! <a href=/index>Перейти на сайт</a>';
            $event->setResponse(new Response($st));

/*
            $collection = new RouteCollection();
            $collection->add('acme_privacy', new Route('/privacy', array(
                '_controller' => 'FrameworkBundle:Template:template',
                'template'    => 'page404.html.twig',
            )));

            return $collection;
*/
        }else{
       /*     $message = $this->getContainer()->get('twig')->render('frontend/error.html.twig', [
                'error'=>$exception->getMessage()
            ]);
            $response = new Response();
            $response->setContent($message);
            $response->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
            $event->setResponse($response);
*/
        }
    }
}