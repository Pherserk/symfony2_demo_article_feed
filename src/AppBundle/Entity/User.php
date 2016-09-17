<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=32)
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=false,length=128)
     */
    private $password;


    /**
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", nullable=false, length=256)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false, length=16)
     */
    private $mobileNumber;

    /**
     * @ORM\OneToOne(targetEntity="ConfirmationPin", cascade={"persist"})
     * @ORM\JoinColumn(name="confirmation_pin_id", referencedColumnName="id", onDelete="set null")
     */
    private $confirmationPin;

    /**
     * @ORM\OneToOne(targetEntity="ConfirmationToken", cascade={"persist"})
     * @ORM\JoinColumn(name="confirmation_token_id", referencedColumnName="id", onDelete="set null")
     */
    private $confirmationToken;

    /**
     * User constructor.
     * @param string $username
     * @param string $email
     * @param string $mobileNumber
     */
    public function __construct($username, $email, $mobileNumber)
    {
        $this->username = $username;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
        $this->salt = null;
        $this->confirmationPin = null;
        $this->confirmationToken = null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return $this
     */
    public function eraseCredentials()
    {
        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @return ConfirmationPin
     */
    public function getConfirmationPin()
    {
        return $this->confirmationPin;
    }

    /**
     * @param ConfirmationPin $confirmationPin
     * @return $this
     */
    public function setConfirmationPin(ConfirmationPin $confirmationPin)
    {
        $this->confirmationPin = $confirmationPin;
        return $this;
    }

    /**
     * @return ConfirmationToken
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param ConfirmationToken $confirmationToken
     * @return User
     */
    public function setConfirmationToken(ConfirmationToken $confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
        return $this;
    }
}

