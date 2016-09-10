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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $emailConfirmedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $mobileConfirmedAt;

    /**
     * @ORM\Column(type="string", nullable=false, length=8)
     */
    private $confirmationPin;

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
        $this->emailConfirmedAt = null;
        $this->mobileConfirmedAt = null;
        $this->confirmationPin = null;
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
     * @return \DateTime
     */
    public function getEmailConfirmedAt()
    {
        return $this->emailConfirmedAt;
    }

    /**
     * @param \DateTime $emailConfirmedAt
     * @return User
     */
    public function setEmailConfirmedAt(\DateTime $emailConfirmedAt)
    {
        $this->emailConfirmedAt = $emailConfirmedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMobileConfirmedAt()
    {
        return $this->mobileConfirmedAt;
    }

    /**
     * @param \DateTime $mobileConfirmedAt
     * @return User
     */
    public function setMobileConfirmedAt(\DateTime $mobileConfirmedAt)
    {
        $this->mobileConfirmedAt = $mobileConfirmedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationPin()
    {
        return $this->confirmationPin;
    }

    /**
     * @param $confirmationPin
     * @return $this
     */
    public function setConfirmationPin($confirmationPin)
    {
        $this->confirmationPin = $confirmationPin;

        return $this;
    }
}
