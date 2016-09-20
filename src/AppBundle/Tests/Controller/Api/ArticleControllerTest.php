<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends ApiWebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
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

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/articles', [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('An awesome title', $decodedResponse->title);
        $this->assertEquals('A very useful and self-explaining text to make some fixtural request', $decodedResponse->text);

        $this->assertEquals($loggedUser->getUsername(), $decodedResponse->user->username);
    }

    public function testShowAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
            ])
            ->getReferenceRepository();

        $client = static::createClient();

        $headers = [];
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request(
            'GET',
            sprintf('/api/articles/%d', $referenceRepository->getReference('article-1')->getId()),
            [],
            [],
            $headers
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('Title of article 1', $decodedResponse->title);
        $this->assertEquals('Text of article 1', $decodedResponse->text);
    }
}
