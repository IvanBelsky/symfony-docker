<?php

namespace App\Controller;

use App\DataOperations\DataManager\UserDataManager;
use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\User;
use App\Events\SendEmailEvent;
use App\EventSubscriber\CheckEmailSubscriber;
use App\Repository\ArticlesRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;


class DefaultController extends AbstractController
{

    public function showArticles(ArticlesRepository $articlesRepository)
    {
        $listArticles = $articlesRepository->getListArticles();
        $listArticlesArray = [];
        foreach ($listArticles as $article) {
            $listArticlesArray[] = [
                'id'=>$article['id'],
                'name' => $article['name']
            ];
        }
        return $this->render('articles_show.html.twig',['items'=>$listArticlesArray, 'page'=>0]);

    }

    public function login()
    {
        return $this->render('login.html.twig',[]);
    }


    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     * @OA\Parameter(
     *     name="order",
     *     in="query",
     *     description="The field used to order rewards",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="ind")
     * @Security(name="Bearer")
     *
     */
    public function genUser(UserDataManager $userDataManager, Request $request, EventDispatcherInterface $eventDispatcher): Response
    {

        $parameters = $request->query->all();
        $isLog = (int)$parameters['isLog'];
        $user = $userDataManager->addUser((bool)$isLog);
        $eventDispatcher->dispatch(new SendEmailEvent($user,'Hello new user!'),SendEmailEvent::SEND_EMAIL);
        return new Response('Create a new record with id '
            .$user->getId().'  '.$user->getFirstName() . ($isLog ? 'with ip' : ''));
    }

    /**
     * Show short user info.
     *
     * @OA\Tag(name="ind4")
     * @Security(name="Bearer")
     *
     */
    public function showById(UserDataProvider $userDataProvider, User $user): JsonResponse
    {
        $id = $user->getId();
        $resp = $userDataProvider->showUserById($id);
      return new JsonResponse($resp);
    }

    /**
     * Defaultcontroller, function genComment
     * @Entity("$user", expr="repository.find(id)")
     *
     * @param User $user
     *
     * @return Response
     */
    public function genComment(User $user, UserDataManager $userDataManager, Request $request): Response
//    public function genComment(UserDataProvider $userDataProvider, UserDataManager $userDataManager, Request $request): Response
    {
        //$parameters = $request->query->all();
        //$id = (int)$parameters['id'];
        $arrayForGenComment=['???????? ???? ????????','???????? ?? ?????????? ?? ??????????????????','???????? ???? ?????????????? ?? ????????????????','???????? ?????????? ????????'];
        $comment = $userDataManager->addUserComment($user,'?????? ?????????????? ?? '.$arrayForGenComment[rand(0,3)].'  id='.$user->getId());
        return new Response($comment->getContent());
    }

        /**
     * @Entity("$user", expr="repository.find(id)")
     *
     * @param User $user
     *
     * @return Response
     */
    public function deleteById(User $user, UserDataManager $userDataManager):Response
    {
        //todo add validation

        $userDataManager->delete($user);


        return new Response('delete ????????????????????????');
    }

    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     * @OA\Parameter(
     *     name="order",
     *     in="query",
     *     description="The field used to order rewards",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="rewards")
     * @Security(name="Bearer")
     *
     */
    public function admin_1(Request $request)
    {
       // return new Response($request->getHttpHost() . $request->getPathInfo());
       // return $this->render('content1.html.twig',['items'=>'fdklgdfjg']);
    }

    /*   public function showUsers(UserRepository $userRepository)
       {
           $listUsers = $userRepository->getListUsers();
           $listUsersArray = [];
           foreach ($listUsers as $user) {
               $listUsersArray[] = [
                   'id' => $user['id'],
                   'name' => $user['firstName'],
                  'ipAdr' => $user['ipAdr']
               ];
           }
           return $this->render('content1.html.twig',['items'=>$listUsersArray]);
       }
   */
       public function showUsers(UserRepository $userRepository, Request $request)
        {
            $arr = explode('/',$request->getRequestUri());
            $offset = intval( end($arr));

         //   $parameters = $request->query; //->all();
        //    $isLog = (int)$parameters['page'];

         //   dd( $parameters);

            $listUsers = $userRepository->getListUsers($offset);
   /*         $listUsersArray = [];
            foreach ($listUsers as $user) {
                $listUsersArray[] = [
                    'id' => $user['id'],
                    'name' => $user['firstName']
                ];
            }
     */
          //  return $this->render('content1.html.twig',['items'=>$listUsersArray, 'page'=>0]);
            return $this->render('content1.html.twig',['items'=>$listUsers,
                'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($listUsers), $offset + UserRepository::PAGINATOR_PER_PAGE),
                'page'=>0]);
        }




    /**
     * @Route("/user_show", methods={"POST"})
     */

  //  public function save(User $user){}

    public function createUser(Request $request, UserRepository $userRepository): Response
    {
        $userData = json_decode($request->getContent(), true);
        print_r($userData);
        print_r($request->getPort());

        $user = new User();
        $user->setEmail('my34@mail.com');
        $user->setPassword('123456');

       // $userRepository->save($user);
        $user->save($user);

        return new Response('???????? ?????????????? ????????????????????????');
    }

    public function index()
    {  // $ap=['user'=>false];
        return $this->render('base.html.twig',[]);
    }


    public function addUser()
    {
        $items = [];
        return $this->render('content1.html.twig',['items'=>$items]);
    }
}
