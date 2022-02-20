<?php

namespace App\DataFixtures;

use App\DataOperations\DataProvider\UserDataProvider;
use App\Entity\Address;
use App\Entity\Articles;
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
    protected $articleName1 = ['Компания Sonatic ','Microsoft ','Tesla ', 'Nokia ', ];
    protected $articleName2 = ['разрабатывает ', 'начанает производство ','представляет ','выводит на рынок','завершает '];
    protected $articleName3 = ['новый софт ','автомобиль на батарейках ','новый продукт ','новую технологию передачи чего-то ','всё '];
    protected $words = ['несмотря ', 'на ', 'то,', 'что ', 'технологии ', 'искусственного ', 'интеллекта ',
                        'компания ', 'разработала ', 'алгоритм ','развиваются ', 'очень ', 'быстро '];

    public function __construct(UserPasswordHasherInterface $hasher, UserDataProvider $userDataProvider, UserRepository $userRepository)
    {
        $this->hasher = $hasher;
        $this->userDataProvider = $userDataProvider;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstName($this->customName());
            $user->setLastName($this->customSurname());
            $user->setRoles(['ROLE_USER']);
            $user->setEmail( $user->getFirstName().$i.'@gmail.com');
            if ($i == 1)
                {$user->setEmail('mosts1923069119@tut.by');
                 $user->setRoles(['ROLE_ADMIN']);
                };
            $user->setPassword($this->hasher->hashPassword($user, '123456'));
            $user->setAge(random_int(18,100));
            $user->setDateCreated(new \DateTime());
            $user->setIsActive(true);
            $manager->persist($user);
        }
        $manager->flush();

        //*****************************************************************************
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
        //***************************************************************************
        for ($i = 0; $i<$this->userCount*3; $i++)
        {
            $articles = new Articles();
         //   $articles->setUser($listUsers[0]);
            $articles->setUser($listUsers[random_int(0,$this->userCount-1)]);
            $articles->setName($this->customArticleName());
            $articles->setFoto('img'.$i.'.jpeg');
            $articles->setTextArt($this->customArticleText());
            $manager->persist($articles);
        }
        $manager->flush();
        //***************************************************************************

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

    public function customArticleName()
    {
        return $this->articleName1[rand(0, count($this->articleName1) - 1)]
            .$this->articleName2[rand(0, count($this->articleName2) - 1)]
            .$this->articleName3[rand(0, count($this->articleName3) - 1)];
    }
    public function customArticleText()
    {
        $n = count($this->words);
        $n1 = random_int($n,$n+20);
        $text = '';
        for ($i=0; $i<$n1; $i++) {
            $text = $text.$this->words[random_int(0,$n-1)];
        }

        //return ucfirst($text);
        $this->rus();
        return $this->mb_ucfirst($text);
    }

    //************************
public function rus()
{
    /**
     * проверяем, что функция mb_ucfirst не объявлена
     * и включено расширение mbstring (Multibyte String Functions)
     */
    if(!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
        /**
         * mb_ucfirst - преобразует первый символ в верхний регистр
         *
         * @param string $str      - строка
         * @param string $encoding - кодировка, по-умолчанию UTF-8
         *
         * @return string
         */
    }
}

    public function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);

        return $str;
    }

//***********************



}
