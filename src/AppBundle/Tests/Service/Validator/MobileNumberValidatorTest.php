<?php

namespace AppBundle\Tests\Service\Validator;


use AppBundle\Service\Validator\MobileNumberValidator;

class MobileNumberValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testValidate($number, array $expectedErrors)
    {
        $validator = new MobileNumberValidator();

        self::assertSame($expectedErrors, $validator->validate($number));
    }

    public function provideData()
    {
        return [
           [
               '3343333242',
               [
                   'Must start with + sign',
               ],
           ],
           [
                '+394344a3333',
               [
                   'Contains invalid characters, after + sign only numbers allowed',
               ],
           ],
        ];
    }
}