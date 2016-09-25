<?php

namespace AppBundle\Tests\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\User\NewUserRequestParser;
use AppBundle\Service\Validator\EmailValidator;
use AppBundle\Service\Validator\MobileNumberValidator;
use AppBundle\Service\Validator\PlainPasswordValidator;
use AppBundle\Service\Validator\UsernameValidator;
use Symfony\Component\HttpFoundation\Request;

class NewUserRequestParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $payLoad = new \stdClass();
        $payLoad->data = new \stdClass();
        $payLoad->data->type = 'users';
        $payLoad->data->attributes = new \stdClass();
        $payLoad->data->attributes->username = 'JohnDoe';
        $payLoad->data->attributes->password = 'J0hNd03sP4sSw0rD';
        $payLoad->data->attributes->email = 'john.doe@example.com';
        $payLoad->data->attributes->mobileNumber = '+3933312345678';

        /** @var Request $request */
        $request = self::prophesize(Request::class);
        $request->getContent()->willReturn(json_encode($payLoad));

        /** @var UsernameValidator $userNameValidator */
        $userNameValidator = self::prophesize(UsernameValidator::class);
        $userNameValidator->validate('JohnDoe')->willReturn([]);

        /** @var PlainPasswordValidator $plainPasswordValidator */
        $plainPasswordValidator = self::prophesize(PlainPasswordValidator::class);
        $plainPasswordValidator->validate('J0hNd03sP4sSw0rD')->willReturn([]);

        /** @var EmailValidator $emailValidator */
        $emailValidator = self::prophesize(EmailValidator::class);
        $emailValidator->validate('john.doe@example.com')->willReturn([]);

        /** @var MobileNumberValidator $mobileNumberValidator */
        $mobileNumberValidator = self::prophesize(MobileNumberValidator::class);
        $emailValidator->validate('+3933312345678')->willReturn([]);

        $parser = new NewUserRequestParser(
            new JsonApiRequestDeserializer(),
            $userNameValidator->reveal(),
            $plainPasswordValidator->reveal(),
            $emailValidator->reveal(),
            $mobileNumberValidator->reveal()
        );

        $parsedRequest = $parser->parse($request->reveal());

        self::assertSame([], $parsedRequest->getErrors());

        $createdUser = $parsedRequest->getData()->data->attributes;
        self::assertEquals('JohnDoe', $createdUser->username);
        self::assertEquals('J0hNd03sP4sSw0rD', $createdUser->password);
        self::assertEquals('john.doe@example.com', $createdUser->email);
        self::assertEquals('+3933312345678', $createdUser->mobileNumber);
    }
}
