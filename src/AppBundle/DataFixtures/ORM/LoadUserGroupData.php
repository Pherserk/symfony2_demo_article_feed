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
        /** @var UserRole $superAdminRole */
        $superAdminRole = $this->getReference('super-admin-role');

        $groupUser = new UserGroup('GROUP_USER');
        $groupSuperAdmin = new UserGroup('GROUP_SUPER_ADMIN');

        $groupUser->addRole($userRole);
        $groupSuperAdmin->addRole($superAdminRole);

        $manager->persist($groupUser);
        $manager->persist($groupSuperAdmin);
        $manager->flush();

        $this->addReference('user-group', $groupUser);
        $this->addReference('super-admin-group', $groupSuperAdmin);
    }

    public function getOrder()
    {
        return 5;
    }
}