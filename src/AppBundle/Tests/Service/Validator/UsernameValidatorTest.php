<?php

namespace AppBundle\Tests\Service\Validator;


use AppBundle\Service\Validator\UsernameValidator;

class UsernameValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testValidate(
        $minimumLength,
        $maximumLength,
        $admitNumbers,
        $admitSpaces,
        $admittedSpecialChars,
        $name,
        array $expectedErrors
    )
    {
        $validator = new UsernameValidator(
            $minimumLength,
            $maximumLength,
            $admitNumbers,
            $admitSpaces,
            $admittedSpecialChars
        );

        self::assertSame($expectedErrors, $validator->validate($name));
    }

    public function provideData()
    {
        return [
            [
                2,
                10,
                false,
                false,
                [],
                'john.doe',
                [],
            ],
            [
                2,
                10,
                false,
                false,
                [],
                'john doe 22 the best',
                [
                    'Must have a maximum length of 10 characters',
                    'Must not contain numbers',
                    'Must not contain spaces',
                ],
                2,
                10,
                false,
                false,
                [],
                'jo',
                [
                    'Must have a minimum length of 2 characters',
                ],
            ],
        ];
    }
}