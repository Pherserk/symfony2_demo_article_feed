<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Service\Security\ConfirmationPinBuilder;

class ConfirmationPinBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $alphabet = 'ABC012';
        $glyphs = str_split($alphabet, 1);

        $before = new \DateTime('now');

        $builder = new ConfirmationPinBuilder($alphabet, 3, 60);
        $pin = $builder->make();

        $after = new \DateTime('now');

        $createdAt =  $pin->getCreatedAt();
        $pin = $pin->getPin();

        self::assertEquals(3, strlen($pin));
        self::assertContains($pin[0], $glyphs);
        self::assertContains($pin[1], $glyphs);
        self::assertContains($pin[2], $glyphs);

        self::assertGreaterThanOrEqual($before, $createdAt);
        self::assertLessThanOrEqual($after, $createdAt);
    }
}
