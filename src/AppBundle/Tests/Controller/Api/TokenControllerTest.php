<?php

namespace AppBundle\Tests\Controller\Api;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TokenControllerTest extends WebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('user-1');

        $client = static::makeClient(
            [
                'username' => $loggedUser->getUsername(),
                'password' => 'password1',
            ]
        );
        
        $client->request('POST', '/api/tokens');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertAttributeNotEmpty(
            'token',
            $decodedResponse
        );
    }
}