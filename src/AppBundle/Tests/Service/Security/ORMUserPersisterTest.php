<?php

namespace AppBundle\Tests\Service\Security;


use AppBundle\Entity\User;
use AppBundle\Service\Security\ORMUserPersister;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Prophecy\ObjectProphecy;

class ORMUserPersisterTest extends \PHPUnit_Framework_TestCase
{
    public function testStore()
    {
        $user = new User('JohnDoe', 'mypassword', 'john.doe@example.com', '3331234567');

        /** @var ObjectProphecy|EntityManagerInterface $em */
        $em = self::prophesize(EntityManagerInterface::class);

        $em->persist($user)->willReturn();
        $em->flush($user)->willReturn();

        $persister = new ORMUserPersister($em->reveal());

        $persister->store($user);
    }
}