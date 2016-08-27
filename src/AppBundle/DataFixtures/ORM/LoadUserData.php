<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User('Username1', 'user.name.1@example.com');
        $user2 = new User('Username2', 'user.name.2@example.com');

        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user-1', $user1);
        $this->addReference('user-2', $user2);
    }

    public function getOrder()
    {
        return 1;
    }
}
