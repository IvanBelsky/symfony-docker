<?php

namespace App\DataOperations\DataManager;

use App\Entity\User;
use App\Entity\UserIpLog;
use Doctrine\ORM\EntityManagerInterface;


class UserIpLogDataManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addIpLog(User $user):void
    {
        $userIpLog = new UserIpLog();
        $userIpLog->setDateCreated(new \DateTime());
        $userIpLog->setIpAdr('192.168.58.'.rand(1,254));
        $userIpLog->setUser($user);
        $this->entityManager->persist($userIpLog);
        $this->entityManager->flush();

    }

}