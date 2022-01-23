<?php
//Файл используется для: добавления, удаления, обновления
namespace App\DataOperations\DataManager;


use App\Entity\User;
use App\Entity\UserIpLog;
use Doctrine\ORM\EntityManagerInterface;

class UserDataManager
{
    private $entityManager;

    private $userIpLogDataManager;

    public function __construct(EntityManagerInterface $entityManager, UserIpLogDataManager $userIpLogDataManager)
    {
        $this->entityManager = $entityManager;
        $this->userIpLogDataManager = $userIpLogDataManager;
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
}
