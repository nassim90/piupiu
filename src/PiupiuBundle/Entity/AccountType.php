<?php

namespace PiupiuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AccountType
 *
 * @ORM\Table(name="account_type")
 * @ORM\Entity(repositoryClass="PiupiuBundle\Repository\AccountTypeRepository")
 */
class AccountType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255, unique=true)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="account_type")
     * @Assert\Valid()
     */
    private $users;

    function __construct() {
        $this->users = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return AccountType
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Add user
     *
     * @param \PiupiuBundle\Entity\User $user
     *
     * @return AccountType
     */
    public function addUser(\PiupiuBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \PiupiuBundle\Entity\User $user
     */
    public function removeUser(\PiupiuBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
