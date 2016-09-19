<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\DeleteUserGroupRequestParser;
use AppBundle\Service\JsonApi\Validator\JsonRequestValidator;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserGroupRequestParerTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $payLoad = new \stdClass();

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $jsonRequesDeserializer = new JsonRequestDeserializer();
        $jsonRequestValidator = new JsonRequestValidator();
        $newUserGroupRequestParser = new DeleteUserGroupRequestParser($jsonRequesDeserializer, $jsonRequestValidator);

        $parsedRequest = $newUserGroupRequestParser->parse($request->reveal());

        self::assertSame([], $parsedRequest->getErrors());
        self::assertEquals($payLoad, $parsedRequest->getData());
    }
}