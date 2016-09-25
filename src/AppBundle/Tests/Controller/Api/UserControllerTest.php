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

        $payLoad = new \stdClass();

        $attributes = new \stdClass();
        $attributes->username = 'JohnDoe';
        $attributes->password = 'J0hNd03sP4sSw0rD';
        $attributes->email = 'john.doe@example.com';
        $attributes->mobileNumber = '+3933312345678';

        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'users';
        $payLoad->data->attributes = $attributes;

        $client = static::createClient();

        $data = json_encode($payLoad);

        $headers = [];
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/users', [], [], $headers, $data);
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('JohnDoe', $decodedResponse->data->attributes->username);
        $this->assertEquals('john.doe@example.com', $decodedResponse->data->attributes->email);
        $this->assertEquals('+3933312345678', $decodedResponse->data->attributes->mobile_number);

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
        $payLoad = new \stdClass();

        $attributes = new \stdClass();
        $attributes->email = 'john.doe@example.com';
        $attributes->mobileNumber = '3933312345678';

        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'users';
        $payLoad->data->attributes = $attributes;

        $payLoad2 = new \stdClass();

        $attributes2 = new \stdClass();
        $attributes2->username = 'JohnDoe';
        $attributes2->password = 'thePassword';
        $attributes2->email = 'john.doe@example.com';
        $attributes2->mobileNumber = '+3933312345678';

        $payLoad2->data = new \stdClass();
        $payLoad2->data->type = 'users';
        $payLoad2->data->attributes = $attributes2;

        return [
            [
                $payLoad,
                [
                    'data' => [
                        'attributes' => [
                            'username' => ['Missing field'],
                            'password' => ['Missing field'],
                            'mobileNumber' => ['Must start with + sign'],
                        ],
                    ],
                ],
            ],
            [
                $payLoad2,
                [
                    'data' => [
                        'attributes' => [
                            'password' => ['Must contain at least 1 number'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
