<?php

namespace Tests\Controller;

use Silex;

class LunchControllerTest extends Silex\WebTestCase
{
    public function createApplication()
    {
        $app = new Silex\Application();
        require __DIR__ . '/../../resources/config/test.php';
        return require __DIR__.'/../../src/app.php';
    }

    public function testLunchAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/lunch?ingredient[]=Ham&ingredient[]=Cheese');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('content_type'));
    }
}
