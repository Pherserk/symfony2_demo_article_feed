<?php

namespace AppBundle\Tests\Service\Security;



use AppBundle\Service\Security\ConfirmationTokenBuilder;

class ConfirmationTokenBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $alphabet = '0123456789ABCDEFGJKHILMNOPQRSTUVWXYZ\|!"£$%&/()=?^[]{}+*@#°§<>,;.:_-/´`';
        $builder = new ConfirmationTokenBuilder($alphabet, 3);

        $glyphs = str_split($alphabet, 1);

        $before = new \DateTime('now');
        $token = $builder->make();

        $after = new \DateTime('now');

        $createdAt =  $token->getCreatedAt();
        $token = $token->getToken();

        self::assertEquals(3, strlen($token));
        self::assertContains($token[0], $glyphs);
        self::assertContains($token[1], $glyphs);
        self::assertContains($token[2], $glyphs);
        
        self::assertGreaterThanOrEqual($before, $createdAt);
        self::assertLessThanOrEqual($after, $createdAt);
    }
}
