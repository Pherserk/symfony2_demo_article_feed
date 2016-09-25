<?php

namespace AppBundle\Tests\Service\JsonApi\Response;


use AppBundle\Service\JsonApi\Response\JsonApiResponseBuilder;
use AppBundle\Service\JsonApi\Serializer\JsonApiSerializer;

class JsonApiResponseBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideResponseData
     */
    public function testMake($payLoad, $type, $statusCode)
    {
        $expectedSerialization = json_encode(null);
        if (null !== $payLoad) {
            $expectedSerialization = sprintf('{"data": {"type": "%s"}}', $type);
        }

        /** @var JsonApiSerializer $serializer */
        $serializer = self::prophesize(JsonApiSerializer::class);
        
        $serializer->serialize($payLoad, $type)
            ->willReturn($expectedSerialization);

        $serializer = $serializer->reveal();

        $builder = new JsonApiResponseBuilder($serializer);

        $response = $builder->make($payLoad, $type, $statusCode);

        self::assertEquals($statusCode, $response->getStatusCode());

        $decodedResponse = json_decode($response->getContent());

        if (null !== $payLoad) {
            self::assertNotNull($decodedResponse);
            self::assertEquals($decodedResponse->data->type, $type);
        } else {
            self::assertNull($decodedResponse);
        }
    }

    public function provideResponseData()
    {
        $payLoad = new \stdClass();

        return [
            [$payLoad, 'fooBars', 416],
            ['Woooh oh anything pass', 'barFoos', 201],
            [null, 'barFoos', 200],
        ];
    }
}
