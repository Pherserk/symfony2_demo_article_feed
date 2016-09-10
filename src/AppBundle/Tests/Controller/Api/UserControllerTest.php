<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends ApiWebTestCase
{
    public function testNewAction()
    {
        $client = static::createClient();

        $data = json_encode(
            [
                'username' => 'John Doe',
                'password' => 'J0hNd03sP4sSw0rD',
                'email' => 'john.doe@example.com',
                'mobileNumber' => '33312345678',
            ]
        );

        $client->request('POST', '/api/users', [], [], [], $data);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals('John Doe', $decodedResponse->username);
        $this->assertEquals('john.doe@example.com', $decodedResponse->email);
        $this->assertEquals('33312345678', $decodedResponse->mobile_number);

        $this->markTestSkipped('Should not see confirmation_pin in the serialized object');
        $this->assertObjectNotHasAttribute('confirmation_pin', $decodedResponse);
    }
}
