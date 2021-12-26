<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;


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
    public function index3()
    {
        return new Response('content sdfmsdfsdf');
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
    public function index4()
    {
        $items = [
            ['name' => 'wer', 'age' => 10],
            ['name' => 'hghj', 'age' => 17],
            ['name' => 'spencer', 'age' => 120],
            ['name' => 'vcbcvb', 'age' => 110],
        ];
        return $this->render('base.html.twig',['items'=>$items]);
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
    public function index()
    {
        return new Response('content');
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
