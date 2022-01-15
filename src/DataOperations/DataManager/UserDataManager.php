<?php
//Файл используется для: добавления, удаления, обновления
namespace App\DataOperations\DataManager;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserDataManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
