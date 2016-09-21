<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Service\Security\ConfirmationPinBuilder;
use AppBundle\Service\Security\ConfirmationTokenBuilder;
use AppBundle\Service\Security\UserBuilder;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        /** @var ObjectProphecy|UserPasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = self::prophesize(UserPasswordEncoderInterface::class);

        /** @var ConfirmationPinBuilder $pinGenerator */
        $pinBuilder = new ConfirmationPinBuilder('A', 4);
        $tokenBuilder = new ConfirmationTokenBuilder('/', 8);

        $builder = new UserBuilder($passwordEncoder->reveal(), $pinBuilder, $tokenBuilder);

        $user = $builder->make('johndoe', 'testpassword', 'johndoe@example.com', '3331234567');

        self::assertEquals('johndoe', $user->getUsername());
        self::assertEquals(null, $user->getPassword());
        self::assertEquals('johndoe@example.com', $user->getEmail());
        self::assertEquals('3331234567', $user->getMobileNumber());
        self::assertEquals('AAAA', $user->getConfirmationPin()->getPin());
        self::assertEquals('////////', $user->getConfirmationToken()->getToken());
    }
}