<?php

namespace App\Controller;

use App\DataOperations\DataManager\UserCommentDataManager;
use App\DataOperations\DataManager\UserDataManager;
use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\User;
use App\Entity\UserIpLog;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;


class DefaultController extends AbstractController
{
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
    public function genUser(UserDataManager $userDataManager, Request $request): Response
    {
        $parameters = $request->query->all();
        $isLog = (int)$parameters['isLog'];
        $user = $userDataManager->addUser((bool)$isLog);
        return new Response('Create a new record with id '
            .$user->getId().'  '.$user->getFirstName() . ($isLog ? 'with ip' : ''));
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
     * @Entity("$user", expr="repository.find(id)")
     *
     * @param User $user
     *
     * @return Response
     */
    public function genComment(UserDataProvider $userDataProvider, UserDataManager $userDataManager, Request $request): Response
    {
        $parameters = $request->query->all();
        $id = (int)$parameters['id'];
        $arrayForGenComment=['фото на море','фото в офисе с коллегами','фото на природе с друзьями','фото моего кота'];
        $comment = $userDataManager->addUserComment($id,'Это коммент к '.$arrayForGenComment[rand(0,3)].'  id='. $id);
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


        return new Response('delete пользователя');
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

    public function showUsers(UserRepository $userRepository)
      //  public function showUsers(ManagerRegistry $doctrine)
    {
      //  $userRepository = $doctrine->getRepository(User::class);
        $listUsers = $userRepository->getListUsers();
        /** @var User $user */
        $listUsersArray = [];
        foreach ($listUsers as $user) {
           // $i = $i+1;
            $listUsersArray[] = [
                'id' => $user['id'],
                'name' => $user['firstName'],
                'ipAdr' => $user['ipAdr']
            ];

        }

        return $this->render('content1.html.twig',['items'=>$listUsersArray]);
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

        return new Response('Хочу создать пользователя');
    }

    public function index()
    {
        return $this->render('base.html.twig');
    }

    public function addUser()
    {
        $items = [];
        return $this->render('content1.html.twig',['items'=>$items]);
    }
}
