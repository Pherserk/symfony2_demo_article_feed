<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\User;
use AppBundle\Entity\UserEmailVerification;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserEmailVerificator
 * @package AppBundle\Service\Security
 */
class UserEmailVerificator
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * UserEmailVerificator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param $email
     * @param $token
     */
    public function verify(User $user, $email, $token)
    {
        if ($user->getConfirmationToken() === $token && $user->getEmail() === $email) {
            $verification = $this->em
                ->getRepository(UserEmailVerificator::class)
                ->findOneBy(['user' => $user, 'email' => $email]);

            if ($verification === null) {
                $verification = new UserEmailVerification($user, $email);
            }

            if (null === $verification->getConfirmedAt()) {
                $verification->setConfirmedAt(new \DateTime('now'));
                $this->em->persist($verification);
                $this->em->flush($verification);
            }
        }
    }
}
