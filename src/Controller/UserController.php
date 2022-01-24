<?php

namespace App\Controller;

use App\Form\CommentType;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

use App\DataOperations\DataManager\UserDataManager;
use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Security;


class UserController extends AbstractController
{
    /**
     * @SWG\Post(
     *      summary="Add comment",
     *      @SWG\RequestBody(
     *          description="",
     *          @Model(type=\App\Form\CommentType::class)
     *      )
     * )
     * @Entity("$user", expr="repository.find(id)")
     * @SWG\Tag(name="users")
     *
     * @param User $user
     *
     * @return Response
     */
    public function addComment(User $user, UserDataManager $userDataManager, Request $request): Response
    {
        //$data = json_decode($request->getContent(), true);
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CommentType::class);
        $form->submit($data);
        if (!$form->isValid()) {
            return new JsonResponse($this->getErrorMessages($form));
        }
        return new JsonResponse($data);
        //$arrayForGenComment=['фото на море','фото в офисе с коллегами','фото на природе с друзьями','фото моего кота'];
        //$comment = $userDataManager->addUserComment($user,'Это коммент к '.$arrayForGenComment[rand(0,3)].'  id='.$user->getId());
        //return new Response($comment->getContent());
    }

    protected function getErrorMessages(FormInterface $form) {
        $errors = array();
        if ($form->count() > 0) {
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = (String) $form[$child->getName()]->getErrors();
                }
            }
        }
        return $errors;
    }
}
