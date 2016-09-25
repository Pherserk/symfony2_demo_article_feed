<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request\UserRole;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\UserRole\NewUserRoleRequestParser;
use Symfony\Component\HttpFoundation\Request;

class NewUserRoleRequestParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $payLoad = new \stdClass();
        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'userRoles';
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->role = 'ROLE_NEW_TEST';

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $parser = new NewUserRoleRequestParser(new JsonApiRequestDeserializer());

        $parsedRequest = $parser->parse($request->reveal());

        self::assertEquals('ROLE_NEW_TEST', $parsedRequest->getData()->data->attributes->role);
    }
}
