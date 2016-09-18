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
        $roleUser = new UserRole('ROLE_USER');
        $roleAdmin = new UserRole('ROLE_ADMIN');
        $roleAllowedToSwitch = new UserRole('ROLE_ALLOWED_TO_SWITCH');
        $roleSuperAdmin = new UserRole('ROLE_SUPER_ADMIN');

        $manager->persist($roleUser);
        $manager->persist($roleAdmin);
        $manager->persist($roleAllowedToSwitch);
        $manager->persist($roleSuperAdmin);

        $manager->flush();

        $this->addReference('user-role', $roleUser);
    }

    public function getOrder()
    {
        return 1;
    }
}