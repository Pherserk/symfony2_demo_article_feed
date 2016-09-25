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

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $parser = new NewUserRoleRequestParser(new JsonApiRequestDeserializer());

        $parsedRequest = $parser->parse($request->reveal());

        self::markTestIncomplete('PayLoad is not complete, response is not complete');
    }
}
