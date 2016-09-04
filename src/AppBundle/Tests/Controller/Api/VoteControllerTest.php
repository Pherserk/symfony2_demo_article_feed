<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VoteControllerTest extends ApiWebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('user-1');
        $ratedArticle = $referenceRepository->getReference('article-2');

        $client = static::createClient();

        $data = json_encode(
            [
                'articleId' => $ratedArticle->getId(),
                'rate' => 5
            ]
        );

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('POST', '/api/votes', [], [], $headers, $data);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals(5, $decodedResponse->rate);
        $this->assertEquals($ratedArticle->getTitle(), $decodedResponse->article->title);

        $this->assertEquals($loggedUser->getUsername(), $decodedResponse->author->username);
    }

    public function testNewAction_NotAcceptableRatingValue()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('user-1');
        $ratedArticle = $referenceRepository->getReference('article-2');

        $client = static::createClient();

        $data = json_encode(
            [
                'articleId' => $ratedArticle->getId(),
                'rate' => 6
            ]
        );

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('POST', '/api/votes', [], [], $headers, $data);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_ACCEPTABLE, $response->getStatusCode());
    }
}
