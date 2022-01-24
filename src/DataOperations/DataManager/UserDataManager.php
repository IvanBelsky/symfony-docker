<?php
//Файл используется для: добавления, удаления, обновления
namespace App\DataOperations\DataManager;


use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\UserIpLog;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserDataManager
{
    private $entityManager;
    private $userIpLogDataManager;
    private $userCommentDataManager;
    private $userDataProvider;

    public function __construct(EntityManagerInterface $entityManager, UserDataProvider $userDataProvider,
                       UserIpLogDataManager $userIpLogDataManager, UserCommentDataManager $userCommentDataManager)
    {
        $this->entityManager = $entityManager;
        $this->userIpLogDataManager = $userIpLogDataManager;
        $this->userCommentDataManager = $userCommentDataManager;
        $this->userDataProvider = $userDataProvider;
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }


    public function addUser(bool $ipLog=false): User
    {
        $user = new User();
        $user->setEmail('mosts'.rand().'@tut.by');
        $user->setPassword('qwe'.rand());
        $user->setDateCreated(new \DateTime());
        $user->setAge(rand(18,120));
        $user->setFirstName('Ivan_'.rand(1,500));
        $user->setIsActive(true);
        $user->setRoles([]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if($ipLog) {
           $this->userIpLogDataManager->addIpLog($user);
        }
        return $user;

    }

    public function addUserComment(int $id, string $content):Comment
    {
        $user = $this->userDataProvider->getUserById($id);
        $comment = new Comment();
        $comment->setContent($content);
        $comment->setUser($user);
        $comment->setDateCreated(new \DateTime());
       $user->addComment($comment);
       $this->entityManager->persist($comment);
        $this->entityManager->flush();
       return $comment;
    }
}
