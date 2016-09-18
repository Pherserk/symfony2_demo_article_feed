<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserGroupControllerTest extends ApiWebTestCase
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

        $loggedUser = $referenceRepository->getReference('super-admin');

        $payLoad =  [
            'name' => 'GROUP_TEST',
        ];

        $data = json_encode($payLoad);

        $client = static::createClient();

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('POST', '/api/user-groups', [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        self::assertEquals('GROUP_TEST', $decodedResponse->name);
    }
}