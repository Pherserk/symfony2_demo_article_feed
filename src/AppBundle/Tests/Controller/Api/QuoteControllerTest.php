<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class QuoteControllerTest extends ApiWebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('user-1');
        $quotedArticle = $referenceRepository->getReference('article-2');

        $client = static::createClient();

        $data = json_encode(
            [
                'articleId' => $quotedArticle->getId(),
                'text' => 'This is an example quote on the article'
            ]
        );

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('POST', '/api/quotes', [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('This is an example quote on the article', $decodedResponse->text);
        $this->assertEquals($quotedArticle->getTitle(), $decodedResponse->article->title);

        $this->assertEquals($loggedUser->getUsername(), $decodedResponse->author->username);
    }
}