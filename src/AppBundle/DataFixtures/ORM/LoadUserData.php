<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\ConfirmationPin;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $confirmationPin1 = new ConfirmationPin('ABCD');
        $confirmationPin2 = new ConfirmationPin('0123');

        $passwordEncoder = $this->container->get('security.password_encoder');

        $user1 = new User('Username1', 'user.name.1@example.com', '333123456789');
        $user2 = new User('Username2', 'user.name.2@example.com', '3333333333');

        $password1 = $passwordEncoder->encodePassword($user1, 'password1');
        $password2 = $passwordEncoder->encodePassword($user2, 'password2');

        $user1
            ->setPassword($password1)
            ->setConfirmationPin($confirmationPin1);
        
        $user2
            ->setPassword($password2)
            ->setConfirmationPin($confirmationPin2);

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
