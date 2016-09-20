<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class UserGroup
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection|UserRole[]
     * @ORM\ManyToMany(targetEntity="UserRole")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * UserGroup constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->roles = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return UserRole[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param UserRole $role
     * @return bool
     */
    public function hasRole(UserRole $role)
    {
        return $this->roles->contains($role);
    }

    /**
     * @param UserRole $role
     * @return $this
     */
    public function addRole(UserRole $role)
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * @param UserRole $role
     * @return $this
     */
    public function removeRole(UserRole $role)
    {
        $this->roles->removeElement($role);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}



