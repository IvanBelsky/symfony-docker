<?php

namespace App\Controller;

use App\Dto\CreateUserDto;
use App\Form\CommentType;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

use App\DataOperations\DataManager\UserDataManager;
use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Null_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Annotation\Route;

use Nelmio\ApiDocBundle\Annotation\Security;

use App\Repository\UserIpLogRepository;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        $output = [];
        parse_str($request->getContent(), $output);
       // $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CommentType::class);
        $form->submit($output);
        if (!$form->isValid()) {
            return new JsonResponse($this->getErrorMessages($form));
        }
        $comment = $userDataManager->addUserComment($user,$output['comment']);
        return new Response('Все ок. Коммент='.$output['comment'].'  Дата = '.$output['calendar']);

        //$arrayForGenComment=['фото на море','фото в офисе с коллегами','фото на природе с друзьями','фото моего кота'];
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

    /**
    * @Entity("$user", expr="repository.find(id)")
    * @param User $user
    * @return Response
    */
    public function showFormAddComment(User $user)
    {
                return $this->render('usercommentadd.html.twig',['item'=>$user->getId()]);
    }

    public function showFormAddNewUser()
    {
        return $this->render('addnewuser.html.twig',['item'=>777]);
    }



    /**
     * @Entity("$user", expr="repository.find(id)")
     * @param User $user
     * @return Response
     */
    public function showUserInfoById(Request $request, User $user, UserDataProvider $userDataProvider,
              UserIpLogRepository $ipLogRepository): Response
    {
        $arr = explode('/',$request->getRequestUri());
        $offset = intval( end($arr));
      //  return new Response(var_dump($offset));
       // $offset = max(0, $request->query->getInt('offset', 0));
       // $offset = 2;
        $iplog = $ipLogRepository->findAllIp($user->getId(),$offset);
        //$iplog = $userDataProvider->getUserIpLog($user->getId(), $ipLogRepository);
        $info = $userDataProvider->showUserById($user->getId());
        return $this->render('userinfo.html.twig',['items'=>$user->getComments()->toArray(),
               'info'=>$info, 'iplog'=>$iplog,
            'previous' => $offset - UserIpLogRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($iplog), $offset + UserIpLogRepository::PAGINATOR_PER_PAGE)
            ]);

        /*    var_dump($iplog);
            array(1) { [0]=> array(4) { ["id"]=> string(1) "6"
            ["ip_adr"]=> string(14) "192.168.58.202"
            ["date_created"]=> string(19) "2022-01-23 15:47:56"
            ["user_id"]=> string(2) "44" } } 1
        return new JsonResponse(count($iplog));
        */
    }

    /**
     * @SWG\Post(
     *      summary="Add user for validatinon",
     *      @SWG\RequestBody(
     *          description="",
     *          @Model(type=\App\Form\UserType::class)
     *      )
     * )
     * @SWG\Tag(name="users")
     *
     * @return Response
     */
    public function createUser(Request $request, ValidatorInterface $validator)
    {
        $data = [];
        parse_str($request->getContent(), $data);

      //  $data = json_decode($request->getContent(), true);
       // dd( $data); return 0;
        $dto = new CreateUserDto($data['email'], $data['first_name'], $data['last_name'],
            $data['password'], $data['age']);

        $valid = $validator->validate($dto);
        $errors = [];
        if (0 !== count($valid)) {
            foreach ($valid as $item) {
                $errors[] = [
                    'message' => $item->getMessage(),
                    'field' => $item->getPropertyPath(),
                ];
            }
            return new JsonResponse($errors);
        }
     /*   $form = $this->createForm(CommentType::class);
        $form->submit($output);
        if (!$form->isValid()) {
            return new JsonResponse($this->getErrorMessages($form));
        }
       */ return new JsonResponse('ok');
    }
}
