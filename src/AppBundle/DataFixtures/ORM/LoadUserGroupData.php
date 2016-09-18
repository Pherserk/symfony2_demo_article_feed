<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\UserGroup;
use AppBundle\Entity\UserRole;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var UserRole $userRole */
        $userRole = $this->getReference('user-role');

        $groupUser = new UserGroup('GROUP_USER');

        $groupUser->addRole($userRole);

        $manager->persist($groupUser);
        $manager->flush();

        $this->addReference('user-group', $groupUser);
    }

    public function getOrder()
    {
        return 5;
    }
}