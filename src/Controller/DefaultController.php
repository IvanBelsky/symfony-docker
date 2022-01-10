<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    public function index3(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setEmail('mosts@tut.by');
        $user->setPassword('qwe');
        $user->setDateCreated(new \DateTime());
        $user->setAge(18);
        $user->setFirstName('Ivan');
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
    public function index4(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $userRepository = $doctrine->getRepository(User::class);
        //$listUsers = $userRepository->findAll();
        $user = $userRepository->find(1);

        //   $listUsersArray = $serializer->deserialize($listUsers);
        /** @var User $user */

        $listUsersArray = [];
//        foreach ($listUsers as $user) {
            //if ($user->getId()=1)
            $listUsersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getFirstName()
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
    public function content1()
    {
        $items = [
            ['name' => 'wer', 'age' => 10],
            ['name' => 'hghj', 'age' => 17],
            ['name' => 'spencer', 'age' => 120],
            ['name' => 'vcbcvb', 'age' => 110],
        ];
        return $this->render('content1.html.twig',['items'=>$items]);
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
    public function index(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $userRepository = $doctrine->getRepository(User::class);
        $listUsers = $userRepository->findAll();

       //   $listUsersArray = $serializer->deserialize($listUsers);
        /** @var User $user */
        $listUsersArray = [];
        foreach ($listUsers as $user) {
            $listUsersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getFirstName()
            ];

        }
        return new JsonResponse($listUsersArray);

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
    public function index1(Request $request)
    {
        return new Response($request->getHttpHost() . $request->getPathInfo());
    }

    /**
     * @Route("/user", name="show_user", methods={"GET"})
     */
    public function showUser(Request $request): Response
    {
        return new Response('Вывожу пользователя');
    }

    /**
     * @Route("/user", methods={"POST"})
     */

  //  public function save(User $user){}

    public function createUser(Request $request, UserRepository $userRepository): Response
    {
        $userData = json_decode($request->getContent(), true);
        print_r($userData);
        print_r($request->getPort());

        $user = new User();
        $user->setEmail('my@mail.com');
        $user->setPassword('123456');

       // $userRepository->save($user);
        $user->save($user);

        return new Response('Хочу создать пользователя');
    }
}
