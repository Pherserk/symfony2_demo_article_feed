<?php

namespace AppBundle\Tests\Service\Validator;


use AppBundle\Service\Validator\DomainNameValidator;

class DomainNameValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testValidate($domainName, array $expectedErrors)
    {
        $validator = new DomainNameValidator();

        self::assertSame($expectedErrors, $validator->validate($domainName));
    }

    public function provideData()
    {
        return [
            [
                'example.com',
                [
                ],
            ],
            [
                'example.co.uk',
                [
                ],
            ],
            [
                'example.f.oo.bar',
                [
                    'Invalid tld f.oo.bar'
                ],
            ],
        ];
    }
}
