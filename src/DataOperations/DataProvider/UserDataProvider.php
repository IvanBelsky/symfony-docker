<?php
//Файл используется для: выбоки данных из БД и их дальнейшей обработки

namespace App\DataOperations\DataProvider;


use App\Repository\UserRepository;

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
}
