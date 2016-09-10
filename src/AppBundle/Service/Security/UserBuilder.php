<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserBuilder
{
    /** @var UserPasswordEncoderInterface $pe */
    private $pe;

    /** @var UserConfirmationPinGenerator $ucpg */
    private $ucpg;

    /**
     * UserBuilder constructor.
     * @param UserPasswordEncoderInterface $pe
     */
    public function __construct(UserPasswordEncoderInterface $pe, UserConfirmationPinGenerator $ucpg)
    {
        $this->pe = $pe;
        $this->ucpg = $ucpg;
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
            ->setConfirmationPin($this->ucpg->generate());

        return $user;
    }
}