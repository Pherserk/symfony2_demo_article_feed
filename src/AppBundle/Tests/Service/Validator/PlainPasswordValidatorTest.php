<?php

namespace AppBundle\Tests\Service\Validator;


use AppBundle\Service\Validator\PlainPasswordValidator;

class PlainPasswordValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testValidate(
        $plainPassowrd,
        $minimumLength,
        $maximumLength,
        $minimumNumbersCount,
        $minimumUppercaseLettersCharsCount,
        $minimumLowerCaseLettersCharsCount,
        $minimumSpecialCharsCount,
        $admittedSpecialChars,
        $expectedErrors
    )
    {
        $validator = new PlainPasswordValidator(
            $minimumLength,
            $maximumLength,
            $minimumNumbersCount,
            $minimumUppercaseLettersCharsCount,
            $minimumLowerCaseLettersCharsCount,
            $minimumSpecialCharsCount,
            $admittedSpecialChars
        );

        $errors = $validator->validate($plainPassowrd);
        self::assertEquals($errors, $expectedErrors);
    }

    public function provideData()
    {
        return [
            [
                'AAbb&%12',
                3,
                8,
                2,
                2,
                2,
                2,
                ['&','%'],
                [],
            ],
            [
                'Aabc£$123',
                3,
                9,
                1,
                1,
                1,
                1,
                ['£','$'],
                [],
            ],
            [
                'Ab1%cd',
                5,
                8,
                1,
                1,
                1,
                1,
                ['&','%'],
                [],
            ],
        ];
    }
}