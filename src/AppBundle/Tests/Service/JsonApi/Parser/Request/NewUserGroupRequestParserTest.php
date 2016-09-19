<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\NewUserGroupRequestParser;
use AppBundle\Service\JsonApi\Validator\JsonRequestValidator;
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

        $jsonRequesDeserializer = new JsonRequestDeserializer();
        $jsonRequestValidator = new JsonRequestValidator();
        $newUserGroupRequestParser = new NewUserGroupRequestParser($jsonRequesDeserializer, $jsonRequestValidator);

        $parsedRequest = $newUserGroupRequestParser->parse($request->reveal());

        self::assertSame([], $parsedRequest->getErrors());
        self::assertEquals($payLoad, $parsedRequest->getData());
    }
}
