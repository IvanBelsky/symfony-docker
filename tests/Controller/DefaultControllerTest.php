<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{




    public function testSomething(): void
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');

/*        // включает профилировщика для всех следующих запросов
        $client->enableProfiler();

        $crawler = $client->request('GET', '/profiler');

// Проверьте, подключен ли профилировщик
        if ($profile = $client->getProfile()) {
            // проверьте количество запросов
            $this->assertLessThan(
                1,
                $profile->getCollector('db')->getQueryCount(),
                sprintf(
                    'Checks that query count is less than 30 (token %s)',
                    $profile->getToken()
                )
            );
            // проверьте время, проведенное в фреймворке
            $this->assertLessThan(
                15,
                $profile->getCollector('time')->getDuration()
            );

        }
        */
    }
}
