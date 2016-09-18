<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="string", nullable=false, length=32, unique=true)
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
     * @var ArrayCollection|UserGroup[]
     * @ORM\ManyToMany(targetEntity="UserGroup")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $groups;

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
        $this->groups = new ArrayCollection();
        $this->salt = null;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
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
     * @return UserGroup[]|ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param UserGroup $group
     * @return $this
     */
    public function addGroup(UserGroup $group)
    {
        if (!$this->groups->contains($group)) {
             $this->groups->add($group);
        }
        
        return $this;
    }

    /**
     * @param UserGroup $group
     * @return $this
     */
    public function removeGroup(UserGroup $group)
    {
        $this->groups->removeElement($group);
        return $this;
    }

    /**
     * @return string[]
     * This is a proxy and will make some queries, when possibile retrive data once
     */
    public function getRoles()
    {
        $roles = [];
        $groups = $this->getGroups();
        foreach ($groups as $group) {
            $groupRoles = $group->getRoles();
            foreach ($groupRoles as $groupRole) {
                $roles[] = $groupRole->getRole();
            }
        }

        return $roles;
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

