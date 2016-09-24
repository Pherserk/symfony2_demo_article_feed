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

        $payLoad = new \stdClass();

        $attributes = new \stdClass();
        $attributes->name = 'GROUP_TEST';

        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'userGroups';
        $payLoad->data->attributes = $attributes;

        $data = json_encode($payLoad);

        $client = static::createClient();

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('POST', '/api/user-groups', [], [], $headers, $data);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        self::assertEquals('GROUP_TEST', $decodedResponse->data->attributes->name);
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

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request('DELETE', sprintf('/api/user-groups/%d', $groupToDelete->getId()), [], [], $headers, $data);
        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }


    public function testUpdate()
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
        $payLoad->data = new \stdClass();
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->name = 'GROUP_TEST_UPDATE';

        $data = json_encode($payLoad);
        $client = static::createClient();

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request(
            'PATCH',
            sprintf('/api/user-groups/%d', $groupToModify->getId()),
            [],
            [],
            $headers,
            $data
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($groupToModify->getId(), json_decode($response->getContent())->data->id);
        self::assertEquals($payLoad->data->attributes->name, json_decode($response->getContent())->data->attributes->name);
    }

    public function testAddUserRolesAction()
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

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request(
            'POST',
            sprintf('/api/user-groups/%d/relationships/user-roles', $groupToModify->getId()),
            [],
            [],
            $headers,
            $data
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
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

        $headers = [];
        $this->getAuthorizedHeaders($loggedUser->getUsername(), $headers);
        $this->getJsonApiAcceptdHeaders($headers);

        $client->request(
            'DELETE',
            sprintf('/api/user-groups/%d/relationships/user-roles', $groupToModify->getId()),
            [],
            [],
            $headers,
            $data
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

