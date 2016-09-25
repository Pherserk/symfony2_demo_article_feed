<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\User;
use AppBundle\Entity\UserEmailNumberVerification;
use AppBundle\Entity\UserMobileNumberVerification;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserMobileNumberVerificator
 * @package AppBundle\Service\Security
 */
class UserMobileNumberVerificator
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * UserMobileNumberVerificator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param $mobileNumber
     * @param $pin
     */
    public function verify(User $user, $mobileNumber, $pin)
    {
        if ($user->getConfirmationPin() === $pin && $user->getMobileNumber() === $mobileNumber) {
            $verification = $this->em
                ->getRepository(UserMobileNumberVerification::class)
                ->findOneBy(['user' => $user, 'mobileNumber' => $mobileNumber]);

            if ($verification === null) {
                $verification = new UserMobileNumberVerification($user, $mobileNumber);
            }

            if (null === $verification->getConfirmedAt()) {
                $verification->setConfirmedAt(new \DateTime('now'));
                $this->em->persist($verification);
                $this->em->flush($verification);
            }
        }
    }
}
