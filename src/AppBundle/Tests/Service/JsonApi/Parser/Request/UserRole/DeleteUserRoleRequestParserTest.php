<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request\UserRole;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\UserRole\DeleteUserRoleRequestParser;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserRoleRequestParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode(null));

        $parser = new DeleteUserRoleRequestParser(new JsonApiRequestDeserializer());

        $parsedRequest = $parser->parse($request->reveal());

        self::assertNull($parsedRequest->getData());
    }
}
