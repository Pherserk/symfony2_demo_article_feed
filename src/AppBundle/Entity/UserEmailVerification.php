<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_email_verification", uniqueConstraints={@ORM\UniqueConstraint(name="email_user", columns={"user_id", "email_hash"})}))
 */
class UserEmailVerification
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
     * @ORM\Column(type="string", nullable=false, length=256)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false, length=42)
     */
    private $emailHash;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $confirmedAt;

    /**
     * UserMobileNumberVerification constructor.
     * @param User $user
     * @param string $email
     */
    public function __construct(User $user, $email)
    {
        $this->user = $user;
        $this->email = $email;
        $this->emailHash = sha1($email);
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmailHash()
    {
        return $this->emailHash;
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
