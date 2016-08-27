<?php

namespace AppBundle\Tests\Controller\Api;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends WebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('user-1');

        $client = static::createClient();

        $data = json_encode(
            [
                'title' => 'An awesome title',
                'text' => 'A very useful and self-explaining text to make some fixtural request'
            ]
        );

        $client->request('POST', '/api/articles', [], [], [], $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('An awesome title', $decodedResponse->title);
        $this->assertEquals('A very useful and self-explaining text to make some fixtural request', $decodedResponse->text);

        $this->assertEquals($loggedUser->getName(), $decodedResponse->user->name);
    }

    public function testShowAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
            ])
            ->getReferenceRepository();

        $client = static::createClient();

        $client->request(
            'GET',
            sprintf('/api/articles/%d', $referenceRepository->getReference('article-1')->getId())
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('Title of article 1', $decodedResponse->title);
        $this->assertEquals('Text of article 1', $decodedResponse->text);
    }
}
