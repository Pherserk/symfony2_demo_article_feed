<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Service\Security\UserBuilder;
use AppBundle\Service\Security\UserConfirmationPinGenerator;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        /** @var ObjectProphecy|UserPasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = self::prophesize(UserPasswordEncoderInterface::class);

        /** @var UserConfirmationPinGenerator $pinGenerator */
        $pinGenerator = new UserConfirmationPinGenerator('A', 4);

        $builder = new UserBuilder($passwordEncoder->reveal(), $pinGenerator);

        $user = $builder->make('johndoe', 'testpassword', 'johndoe@example.com', '3331234567');

        self::assertEquals('johndoe', $user->getUsername());
        self::assertEquals(null, $user->getPassword());
        self::assertEquals('johndoe@example.com', $user->getEmail());
        self::assertEquals('3331234567', $user->getMobileNumber());
        self::assertEquals('AAAA', $user->getConfirmationPin());
    }
}