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

        $payLoad = new \stdClass();
        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'userRoles';
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->role = 'ROLE_NEW_TEST';

        $data = json_encode($payLoad);

        $client = static::createClient();

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/user-roles', [], [], $headers, $data);
        $response = $client->getResponse();


        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        self::assertEquals('ROLE_NEW_TEST', $decodedResponse->data->attributes->role);
    }

    public function testDeleteAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('super-admin');
        $roleToDelete = $referenceRepository->getReference('allowed-to-switch-role');
        
        $data = json_encode(null);

        $client = static::createClient();

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('DELETE', sprintf('/api/user-roles/%d', $roleToDelete->getId()), [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
