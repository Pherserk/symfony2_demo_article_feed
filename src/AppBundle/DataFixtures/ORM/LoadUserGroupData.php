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
        /** @var UserRole $simple3Role */
        $simple3Role = $this->getReference('simple-3-role');
        /** @var UserRole $simple4Role */
        $simple4Role = $this->getReference('simple-4-role');

        $groupUser = new UserGroup('GROUP_USER');
        $groupSuperAdmin = new UserGroup('GROUP_SUPER_ADMIN');

        $groupUser
            ->addRole($userRole)
            ->addRole($simple3Role)
            ->addRole($simple4Role);

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