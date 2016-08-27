<?php

namespace AppBundle\Tests\Controller\Api;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MainControllerTest extends WebTestCase
{
    public function testWriteArticleAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertEquals('Write a new Article', $crawler->filter('form')->filter('legend')->text());
    }
}