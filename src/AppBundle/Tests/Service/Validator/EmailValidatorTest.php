<?php

namespace AppBundle\Tests\Service\Validator;


use AppBundle\Service\Validator\DomainNameValidator;
use AppBundle\Service\Validator\EmailValidator;

class EmailValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testValidate($email, array $expectedErrors)
    {
        $validator = new EmailValidator(new DomainNameValidator());

        self::assertSame($expectedErrors, $validator->validate($email));
    }

    public function provideData()
    {
        return [
            [
                'john.doe@example.com',
                [
                ],
            ],
            [
                'john.doeexample.com',
                [
                    'Invalid',
                ],
            ],
            [
                'john.doe@example',
                [
                    'Invalid',
                ],
            ],
            [
                'john.doe@example.c',
                [
                    'Invalid domain name',
                ],
            ],
        ];
    }
}