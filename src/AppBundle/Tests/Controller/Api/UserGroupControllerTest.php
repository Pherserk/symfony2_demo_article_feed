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
        $groupToDelete = $referenceRepository->getReference('user-group');

        $payLoad = [];

        $data = json_encode($payLoad);

        $client = static::createClient();

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request('DELETE', sprintf('/api/user-groups/%d', $groupToDelete->getId()), [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    
    public function testUpdateUserRolesAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('super-admin');
        $groupToModify = $referenceRepository->getReference('user-group');

        $payLoad = new \stdClass();

        $relationShip = new \stdClass();
        $relationShip->type = 'userRoles';
        $relationShip->id = $referenceRepository->getReference('simple-role')->getId();

        $relationShip2 = new \stdClass();
        $relationShip2->type = 'userRoles';
        $relationShip2->id = $referenceRepository->getReference('simple-2-role')->getId();

        $payLoad->data = [$relationShip, $relationShip2];

        $data = json_encode($payLoad);
        $client = static::createClient();

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request(
            'POST',
            sprintf('/api/user-groups/%d/relationships/user-roles', $groupToModify->getId()),
            [],
            [],
            $headers,
            $data
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDeleteUserRolesAction()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
            ])
            ->getReferenceRepository();

        $loggedUser = $referenceRepository->getReference('super-admin');
        $groupToModify = $referenceRepository->getReference('user-group');

        $payLoad = new \stdClass();

        $relationShip = new \stdClass();
        $relationShip->type = 'userRoles';
        $relationShip->id = $referenceRepository->getReference('simple-3-role')->getId();

        $relationShip2 = new \stdClass();
        $relationShip2->type = 'userRoles';
        $relationShip2->id = $referenceRepository->getReference('simple-4-role')->getId();

        $payLoad->data = [$relationShip, $relationShip2];

        $data = json_encode($payLoad);
        $client = static::createClient();

        $headers = $this->getAuthorizedHeaders($loggedUser->getUsername());

        $client->request(
            'DELETE',
            sprintf('/api/user-groups/%d/relationships/user-roles', $groupToModify->getId()),
            [],
            [],
            $headers,
            $data
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

