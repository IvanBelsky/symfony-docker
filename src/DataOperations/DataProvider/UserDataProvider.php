<?php
//Файл используется для: выбоки данных из БД и их дальнейшей обработки

namespace App\DataOperations\DataProvider;


use App\Entity\User;
use App\Repository\UserIpLogRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class UserDataProvider
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): array
    {
        $listUsers = $this->userRepository->findAll();
        $listUsersArray = [];
        foreach ($listUsers as $user) {
            $listUsersArray[] = [
                'id' => $user->getId(),
                'name' => $user->getFirstName()
            ];

        }
        return $listUsersArray;
    }

    public function showUserById(int $id): array
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if($user == null){return ['id'=>'No']; exit; };
        /** @var User $user */
        $listUsersArray = [];
        $listUsersArray[] = [
            'id' => $user->getId(),
            'name' => $user->getFirstName(),
            'email' =>$user->getEmail()
        ];

        return $listUsersArray;

    }

    public function getUserById(int $id): User
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
      //  if($user == null){return ['id'=>'No']; exit; };
        return $user;

    }


    public function getUserIpLog(int $id, UserIpLogRepository $ipLogRepository):Paginator
//    public function getUserIpLog(int $id, UserIpLogRepository $ipLogRepository):array
    {
      // return $ipLogRepository->findIpLogById($id);
        return $ipLogRepository->findAllIp($id,2);

    }



}
