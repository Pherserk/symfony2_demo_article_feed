<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Service\Security\UserConfirmationPinGenerator;

class UserPinGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $alphabet = 'ABC012';
        $glyphs = str_split($alphabet, 1);
        $generator = new UserConfirmationPinGenerator($alphabet, 3);
        $pin = $generator->generate();

        self::assertEquals(3, strlen($pin));
        self::assertContains($pin[0], $glyphs);
        self::assertContains($pin[1], $glyphs);
        self::assertContains($pin[2], $glyphs);
    }
}