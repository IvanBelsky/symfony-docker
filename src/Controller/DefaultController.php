<?php

namespace App\Controller;

use App\DataOperations\DataManager\UserDataManager;
use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\User;
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
    public function admin_2_post_gen_user(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $user->setEmail('mosts'.rand().'@tut.by');
        $user->setPassword('qwe'.rand());
        $user->setDateCreated(new \DateTime());
        $user->setAge(rand(18,120));
        $user->setFirstName('Ivan_'.rand(1,500));
        $user->setIsActive(true);
        $user->setRoles([]);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId().'  '.$user->getFirstName());
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
    public function showById(int $id, ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $userRepository = $doctrine->getRepository(User::class);
        //$listUsers = $userRepository->findAll();
       // $user = $userRepository->find(1);
       // $show_by_id = 1;

        if($id == null){exit; };
        //exit;
        $user = $userRepository->findOneBy(['id' => $id]);
        if($user == null){return new JsonResponse(['id'=>'No']); exit; };
        //   $listUsersArray = $serializer->deserialize($listUsers);
        /** @var User $user */

        $listUsersArray = [];
//        foreach ($listUsers as $user) {
            //if ($user->getId()=1)
            $listUsersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getFirstName(),
                'email' =>$user->getEmail()
            ];

  //      }

        return new JsonResponse($listUsersArray);

      /*  $items = [
            ['name' => 'wer', 'age' => 10],
            ['name' => 'hghj', 'age' => 17],
            ['name' => 'spencer', 'age' => 120],
            ['name' => 'vcbcvb', 'age' => 110],
        ];
        return $this->render('base.html.twig',['items'=>$items]);
      */
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
     * @OA\Tag(name="ind")
     * @Security(name="Bearer")
     *
     */
    public function admin_2_get(UserDataProvider $userDataProvider): JsonResponse
    {
        return new JsonResponse($userDataProvider->getAllUsers());
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

    public function showUsers(ManagerRegistry $doctrine)
    {
        $userRepository = $doctrine->getRepository(User::class);
        $listUsers = $userRepository->findAll();
         $i = 0;
        //   $listUsersArray = $serializer->deserialize($listUsers);
        /** @var User $user */
        $listUsersArray = [];
        foreach ($listUsers as $user) {
           // $i = $i+1;
            $listUsersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getFirstName(),
                'urlForDel' => '/api/user/deletebyid/'
            ];

        }

        $items = [
            ['name' => 'wer', 'id' => 1],
            ['name' => 'hghj', 'id' => 17],
            ['name' => 'spencer', 'id' => 120],
            ['name' => 'vcbcvb', 'id' => 110],
        ];
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
        return $this->render('base.html.twig',['items'=>'func index']);
    }

    public function addUser()
    {
        $items = [];
        return $this->render('content1.html.twig',['items'=>$items]);
    }
}
