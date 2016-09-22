<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request\UserGroup;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\UserGroup\UpdateUserGroupRequestParser;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserGroupRequestParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providePayLoadAndExpectations
     */
    public function testParse($payLoad, $errors, $data)
    {
        $parser = new UpdateUserGroupRequestParser(
            new JsonRequestDeserializer()
        );

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        $parsedRequest = $parser->parse($request->reveal());

        self::assertEquals($errors, $parsedRequest->getErrors());
        self::assertEquals($data, $parsedRequest->getData());
    }

    public function providePayLoadAndExpectations()
    {
        $payLoad = new \stdClass();
        $payLoad->data = new \stdClass();
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->name = 'GROUP_TEST';

        $payLoad2 = new \stdClass();
        $payLoad2->data = new \stdClass();
        $payLoad2->data->attributes = new \stdClass();
        $payLoad2->data->attributes->name = 'TEST_GROUP';

        return [
            [$payLoad, [], $payLoad,],
            [$payLoad2, ['data' => ["attributes" => ["name" => "Must start with GROUP_"]]], $payLoad2,],
        ];
    }
}