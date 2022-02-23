<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\Client;

class LoginControllerTest extends WebTestCase
{
        public function testVisitingWhileLoggedIn():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // извлечь тестового пользователя
        $testUser = $userRepository->findOneByEmail('mosts1923069119@tut.by');

        // симулировать вход $testUser в систему
        $client->loginUser($testUser);

        // тестировать, например, страницу профиля
        $crawler = $client->request('GET', '/index');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello? World!');

        //$client = static::createClient();
        //$client->request('GET', '/post/hello-world');

        //var_dump($client->getResponse()->getContent());
        var_dump($crawler);

        $client2 = Client::createChromeClient();
        $client2->request('GET', '/index');
        var_dump($client2->getResponse());
        //$client->submitForm('AllUsers', [],'POST', ['HTTP_ACCEPT_LANGUAGE' => 'en']);
        //$link = $crawler->selectLink("AllUsers")->link();
//          $client->click($link);
          //$client->clickLink('AllUsers');
  /*      // *************************************************

        $client->submitForm('Sign in', [
            'email' => 'mosts1923069119@tut.by',
            'password' => '123456',
        ]);

   */   //***************************************
    }
}
