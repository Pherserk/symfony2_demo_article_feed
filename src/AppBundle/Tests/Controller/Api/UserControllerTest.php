<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends ApiWebTestCase
{
    public function testNewAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
            ])
            ->getReferenceRepository();

        $payLoad =  [
            'username' => 'JohnDoe',
            'password' => 'J0hNd03sP4sSw0rD',
            'email' => 'john.doe@example.com',
            'mobileNumber' => '+3933312345678',
        ];

        $client = static::createClient();

        $data = json_encode($payLoad);

        $headers = [];
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/users', [], [], $headers, $data);
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('JohnDoe', $decodedResponse->username);
        $this->assertEquals('john.doe@example.com', $decodedResponse->email);
        $this->assertEquals('+3933312345678', $decodedResponse->mobile_number);

        $this->markTestSkipped('Should not see confirmation_pin in the serialized object');
        $this->assertObjectNotHasAttribute('confirmation_pin', $decodedResponse);
        $this->assertObjectNotHasAttribute('confirmation_token', $decodedResponse);
    }

    /**
     * @dataProvider providePayload
     */
    public function testNewAction_onBadRequest($payLoad, array $errors)
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
            ])
            ->getReferenceRepository();

        $client = static::createClient();

        $data = json_encode($payLoad);

        $headers = [];
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/users', [], [], $headers, $data);

        $response = $client->getResponse();

        $decodedResponse = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame($errors, $decodedResponse);
    }

    public function providePayload()
    {
        return [
            [
                [
                    'email' => 'john.doe@example.com',
                    'mobileNumber' => '33312345678',
                ],
                [
                    'username' => ['Missing field'],
                    'password' => ['Missing field'],
                    'mobileNumber' => ['Must start with + sign'],
                ],
            ],
            [
                [
                    'username' => 'JohnDoe',
                    'password' => 'thePassword',
                    'email' => 'john.doe@example.com',
                    'mobileNumber' => '+3933312345678',
                ],
                [
                    'password' => ['Must contain at least 1 number'],
                ],
            ],
        ];
    }
}
