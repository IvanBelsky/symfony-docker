<?php
//Добавление, удаление, генерация комментариев
namespace App\DataOperations\DataManager;


use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class UserCommentDataManager
{
    private $entityManager;
    private $arrayForGenComment=['gdgdfg','fgerterdfg','rtyrhythgf34','***4545**'];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /*
    public function addComment(User $user):Comment
    {
        $content = $this->arrayForGenComment[rand(0,3)];
        $userComment = new Comment();
        $userComment->setUser($user);
        $userComment->setContent($content);
        $userComment->setDateCreated(new \DateTime());
        $this->entityManager->persist($userComment);
        $this->entityManager->flush();
        return $userComment;

    }
*/

}