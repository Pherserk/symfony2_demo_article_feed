<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_mobile_number_verification", uniqueConstraints={@ORM\UniqueConstraint(name="mobile_number_user", columns={"user_id", "mobile_number"})}))
 */
class UserMobileNumberVerification
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=false, length=16)
     */
    private $mobileNumber;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $confirmedAt;

    /**
     * UserMobileNumberVerification constructor.
     * @param User $user
     * @param string $mobileNumber
     */
    public function __construct(User $user, $mobileNumber)
    {
        $this->user = $user;
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
    public function getConfirmedAt()
    {
        return $this->confirmedAt;
    }

    /**
     * @param \DateTime $confirmedAt
     * @return $this
     */
    public function setConfirmedAt(\DateTime $confirmedAt)
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }
}
