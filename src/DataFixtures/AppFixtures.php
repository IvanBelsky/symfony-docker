<?php

namespace App\DataFixtures;

use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\Address;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $userCount;
    private $userDataProvider;
    private $userRepository;
    protected $firstnameArray = ['John', 'Sarah', 'Jane', 'Michael', 'Steven', 'Rachel'];
    protected $surnameArray = ['Smith', 'Mills', 'Baker', 'Jones', 'Macher', 'Doe'];
    protected $townArray = ['Minsk', 'Moscow', 'Tokyo', 'Mosty', 'London', 'New-York','Berlin'];
    protected $streetArray = ['Lermontova', 'Pushkina', 'Yantarnaya','Mira', 'Yunosty','Gogoliya','Zelenaya'];


    public function __construct(UserPasswordHasherInterface $hasher, UserDataProvider $userDataProvider, UserRepository $userRepository)
    {
        $this->hasher = $hasher;
        $this->userDataProvider = $userDataProvider;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 21; $i < 40; $i++) {
            $user = new User();
            $user->setFirstName($this->customName());
            $user->setLastName($this->customSurname());
            $user->setEmail( $user->getFirstName().$i.'@gmail.com');
            $user->setPassword($this->hasher->hashPassword($user, '123456'));
            $user->setRoles(['ROLE_USER']);
            $user->setAge(random_int(18,100));
            $user->setDateCreated(new \DateTime());
            $user->setIsActive(true);
            $manager->persist($user);
        }
        $manager->flush();

       // $this->userCount = count($this->userDataProvider->getAllUsers());
        $listUsers = $this->userRepository->findAll();
        $this->userCount = count($listUsers);
        for ($i = 0; $i<$this->userCount; $i++)
        {
            $address = new Address();
            $address->setUser($listUsers[$i]);
            $address->setZipCode(random_int(0,9).'5613'.random_int(0,9));
            $address->setTown($this->customTown());
            $address->setStreet($this->customStreet());
            $address->setHouse(random_int(1,200));
            $address->setFlat(random_int(1,150));
            $manager->persist($address);
        }
        $manager->flush();
    }

    public function customName()
    {
        return $this->firstnameArray[rand(0, count($this->firstnameArray) - 1)];
    }

    public function customSurname()
    {
        return $this->surnameArray[rand(0, count($this->surnameArray) - 1)];
    }

    public function customTown()
    {
        return $this->townArray[rand(0, count($this->townArray) - 1)];
    }

    public function customStreet()
    {
        return $this->streetArray[rand(0, count($this->streetArray) - 1)];
    }

}
