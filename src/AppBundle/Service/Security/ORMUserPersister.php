<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ORMUserPersister implements UserPersisterInterface
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * UserPersister constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     */
    public function store(UserInterface $user)
    {
        if ($user instanceOf User) {
            $this->em->persist($user);
            $this->em->flush($user);
        } else {
            throw new \LogicException('Not a valid user entity');
        }
    }
}
