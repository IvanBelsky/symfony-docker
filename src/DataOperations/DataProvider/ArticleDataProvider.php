<?php

namespace App\DataOperations\DataProvider;


use App\Repository\ArticlesRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArticleDataProvider
{
    private $articleRepository;

    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articleRepository = $articlesRepository;
    }

    public function getArticleComment(int $id, CommentRepository $commentRepository):Paginator
    {
        return $commentRepository->findAllComments($id, 3);

    }

}