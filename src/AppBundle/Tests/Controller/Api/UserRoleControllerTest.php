<?php

namespace AppBundle\Tests\Controller\Api;


use AppBundle\Test\ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserRoleControllerTest extends ApiWebTestCase
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
            'name' => 'ROLE_TEST',
        ];

        $data = json_encode($payLoad);

        $client = static::createClient();

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('POST', '/api/user-roles', [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}