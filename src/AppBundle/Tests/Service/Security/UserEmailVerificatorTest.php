<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Entity\ConfirmationToken;
use AppBundle\Entity\User;
use AppBundle\Entity\UserEmailVerification;
use AppBundle\Service\Security\UserEmailVerificator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prophecy\Argument;

class UserEmailVerificatorTest extends \PHPUnit_Framework_TestCase
{
    public function testVerify()
    {
        $user = new User('JohnSmith', 'johnsmith@example.com', '+393331234567');
        $token = new ConfirmationToken('ABCJ£$SK303012LSKOS');
        $user->setConfirmationToken($token);

        /** @var EntityRepository $repo */
        $repo = self::prophesize(EntityRepository::class);
        $repo->findOneBy(['user' => $user, 'email'=> 'johnsmith@example.com'])->willReturn(null);
        $repo = $repo->reveal();

        /** @var EntityManagerInterface $em */
        $em = self::prophesize(EntityManagerInterface::class);
        $em->getRepository(UserEmailVerification::class)->willReturn($repo);
        $em->persist(Argument::any())->shouldBeCalled();
        $em->flush(Argument::any())->shouldBeCalled();
        $em = $em->reveal();

        $verficator = new UserEmailVerificator($em);

        $verficator->verify($user, 'johnsmith@example.com', 'ABCJ£$SK303012LSKOS');
    }

}
