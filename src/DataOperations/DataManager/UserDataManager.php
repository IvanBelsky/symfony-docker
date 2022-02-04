<?php
//Файл используется для: добавления, удаления, обновления
namespace App\DataOperations\DataManager;

use App\Dto\CreateUserDto;

use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDataManager
{
    private $entityManager;
    private $userIpLogDataManager;
    private $userCommentDataManager;
    private $userDataProvider;
    private $hasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserDataProvider $userDataProvider,
        UserIpLogDataManager $userIpLogDataManager,
        UserCommentDataManager $userCommentDataManager,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->entityManager = $entityManager;
        $this->userIpLogDataManager = $userIpLogDataManager;
        $this->userCommentDataManager = $userCommentDataManager;
        $this->userDataProvider = $userDataProvider;
        $this->hasher = $hasher;
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
        $user->setPassword($this->hasher->hashPassword($user, '123456'));
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

    public function addValidUser(array $data, ValidatorInterface $validator):array
    {
        $res = [];
        $user = new User();
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
            $res = ['user'=>$user->getEmail(), 'errors'=>$errors];
            return $res;
        }

        $user->setEmail($data['email']);
    //    $user->setPassword($data['password']);
        $user->setPassword($this->hasher->hashPassword($user, $data['password']));
        $user->setDateCreated(new \DateTime());
        $user->setAge($data['age']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $res = ['user'=>$user->getEmail(), 'errors'=>$errors];
            return $res;
    }


    public function addUserComment(User $user, string $content):Comment
    {
       // $user = $this->userDataProvider->getUserById($id);
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
