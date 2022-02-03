<?php

namespace App\Controller;


use App\DataOperations\DataProvider\ArticleDataProvider;
use App\Entity\Articles;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class ArticleController extends AbstractController
{
    /**
     * @Entity("$articles", expr="repository.find(id)")
     * @param Articles $articles
     * @return Response
     */
    public function showCommentsById(Request $request, Articles $articles,
        ArticleDataProvider $articleDataProvider,
        CommentRepository $commentRepository): Response
    {
        $arr = explode('/',$request->getRequestUri());
        $offset = intval( end($arr));
        $comm = $commentRepository->findAllComments($articles->getId(),$offset);

        $info = $articleDataProvider->getArticleComment($articles->getId(),$commentRepository);
        return $this->render('articles_comments_show.html.twig',['items'=>$articles->getIdComment()->toArray(),
            'info'=>$info, 'comm'=>$comm,
            'previous' => $offset -CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comm), $offset + CommentRepository::PAGINATOR_PER_PAGE)
        ]);

        /*    var_dump($iplog);
            array(1) { [0]=> array(4) { ["id"]=> string(1) "6"
            ["ip_adr"]=> string(14) "192.168.58.202"
            ["date_created"]=> string(19) "2022-01-23 15:47:56"
            ["user_id"]=> string(2) "44" } } 1
        return new JsonResponse(count($iplog));
        */
    }

}