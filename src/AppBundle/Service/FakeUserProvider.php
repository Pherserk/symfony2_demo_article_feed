<?php

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FakeUserProvider
{
    private $em;

    /**
     * FakeUserProvider constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $userName
     * @return User
     */
    public function get($userName)
    {
        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findOneBy(['name' => $userName]);

        if (is_null($user)) {
            $user = new User($userName, sprintf('%s@example.com', $userName));
            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }
}