<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserBuilder
{
    /** @var UserPasswordEncoderInterface $pe */
    private $pe;

    /** @var ConfirmationPinBuilder $cpb */
    private $cpb;

    /** @var ConfirmationTokenBuilder $ctb */
    private $ctb;

    /**
     * UserBuilder constructor.
     * @param UserPasswordEncoderInterface $pe
     * @param ConfirmationPinBuilder $cpb
     * @param ConfirmationTokenBuilder $ctb
     */
    public function __construct(UserPasswordEncoderInterface $pe, ConfirmationPinBuilder $cpb, ConfirmationTokenBuilder $ctb)
    {
        $this->pe = $pe;
        $this->cpb = $cpb;
        $this->ctb  = $ctb;
    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @param $mobileNumber
     * @return User
     */
    public function make($username, $password, $email, $mobileNumber)
    {
        $user = new User($username, $email, $mobileNumber);

        $user
            ->setPassword($this->pe->encodePassword($user, $password))
            ->setConfirmationPin($this->cpb->make())
            ->setConfirmationToken($this->ctb->make());

        return $user;
    }
}