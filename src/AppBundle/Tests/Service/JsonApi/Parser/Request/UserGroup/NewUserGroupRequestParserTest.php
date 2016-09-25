<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request\UserGroup;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\UserGroup\NewUserGroupRequestParser;
use Symfony\Component\HttpFoundation\Request;

class NewUserGroupRequestParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $payLoad = new \stdClass();
        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'userGroups';
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->name = 'GROUP_TEST';

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $jsonRequesDeserializer = new JsonApiRequestDeserializer();
        $newUserGroupRequestParser = new NewUserGroupRequestParser($jsonRequesDeserializer);

        $parsedRequest = $newUserGroupRequestParser->parse($request->reveal());

        self::assertSame([], $parsedRequest->getErrors());
        self::assertEquals($payLoad, $parsedRequest->getData());
    }
}
