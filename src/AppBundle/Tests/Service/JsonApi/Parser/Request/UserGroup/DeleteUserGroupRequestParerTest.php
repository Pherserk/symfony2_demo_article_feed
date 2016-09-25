<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request\UserGroup;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\UserGroup\DeleteUserGroupRequestParser;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserGroupRequestParerTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $payLoad = new \stdClass();

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $jsonRequesDeserializer = new JsonApiRequestDeserializer();
        $newUserGroupRequestParser = new DeleteUserGroupRequestParser($jsonRequesDeserializer);

        $parsedRequest = $newUserGroupRequestParser->parse($request->reveal());

        self::assertSame([], $parsedRequest->getErrors());
        self::assertEquals($payLoad, $parsedRequest->getData());
    }
}
