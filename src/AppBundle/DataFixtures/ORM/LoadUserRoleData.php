<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\UserRole;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $roleSimple = new UserRole('ROLE_SIMPLE');
        $roleSimple2 = new UserRole('ROLE_SIMPLE_2');
        $roleUser = new UserRole('ROLE_USER');
        $roleAdmin = new UserRole('ROLE_ADMIN');
        $roleAllowedToSwitch = new UserRole('ROLE_ALLOWED_TO_SWITCH');
        $roleSuperAdmin = new UserRole('ROLE_SUPER_ADMIN');

        $manager->persist($roleSimple);
        $manager->persist($roleSimple2);
        $manager->persist($roleUser);
        $manager->persist($roleAdmin);
        $manager->persist($roleAllowedToSwitch);
        $manager->persist($roleSuperAdmin);

        $manager->flush();

        $this->addReference('simple-role', $roleSimple);
        $this->addReference('simple-2-role', $roleSimple2);
        $this->addReference('user-role', $roleUser);
        $this->addReference('admin-role', $roleAdmin);
        $this->addReference('allowed-to-switch-role', $roleAllowedToSwitch);
        $this->addReference('super-admin-role', $roleSuperAdmin);
    }

    public function getOrder()
    {
        return 1;
    }
}