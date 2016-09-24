<?php

namespace AppBundle\Tests\Service\JsonApi\Validator;


use AppBundle\Service\JsonApi\Validator\JsonRequestValidator;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonRequestValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideHeaders
     */
    public function testValidate($acceptHeaders, $contentTypeHeaders, $raiseException)
    {
        /** @var HeaderBag $headerBag */
        $headerBag = self::prophesize(HeaderBag::class);
        $headerBag->get('Accept')->willReturn($acceptHeaders);
        $headerBag->get('Content-Type')->willReturn($contentTypeHeaders);
        $headerBag = $headerBag->reveal();

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->headers =  $headerBag;
        $request = $request->reveal();

        $validator = new JsonRequestValidator();

        if ($raiseException) {
            self::expectException(HttpException::class);
        }

        $validator->validate($request);
    }

    public function provideHeaders()
    {
        return [
            [
                'application/vnd.api+json', 'application/vnd.api+json', false,
            ],
            [
                ['application/vnd.api+json', 'some other header'], ['application/vnd.api+json', 'some other header'], false,
            ],
            [
                ['application/vnd.api+json'], [],  true, //Should fail instead
            ],
            [
                [], ['application/vnd.api+json'], true,
            ],
        ];
    }
}
