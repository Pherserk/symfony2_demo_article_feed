<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Entity\ConfirmationPin;
use AppBundle\Entity\User;
use AppBundle\Entity\UserMobileNumberVerification;
use AppBundle\Service\Security\UserMobileNumberVerificator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prophecy\Argument;

class UserMobileNumberVerificatorTest extends \PHPUnit_Framework_TestCase
{
    public function testVerify()
    {
        $user = new User('JohnSmith', 'johnsmith@example.coms', '+393331234567');
        $pin = new ConfirmationPin('AB012');
        $user->setConfirmationPin($pin);

        /** @var EntityRepository $repo */
        $repo = self::prophesize(EntityRepository::class);
        $repo->findOneBy(['user' => $user, 'mobileNumber'=> '+393331234567'])->willReturn(null);
        $repo = $repo->reveal();

        /** @var EntityManagerInterface $em */
        $em = self::prophesize(EntityManagerInterface::class);
        $em->getRepository(UserMobileNumberVerification::class)->willReturn($repo);
        $em->persist(Argument::any())->shouldBeCalled();
        $em->flush(Argument::any())->shouldBeCalled();
        $em = $em->reveal();

        $verficator = new UserMobileNumberVerificator($em);

        $verficator->verify($user, '+393331234567', 'AB012');
    }

}
