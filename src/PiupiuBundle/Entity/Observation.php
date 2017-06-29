<?php

namespace PiupiuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="PiupiuBundle\Repository\ObservationRepository")
 */
class Observation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_long", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $gpsLong;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_lat", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $gpsLat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="observations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $user;

    /**
     * Many Observations have One Bird.
     * @ORM\ManyToOne(targetEntity="Bird", inversedBy="observations")
     * @ORM\JoinColumn(name="bird_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $bird;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Observation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set gpsLong
     *
     * @param string $gpsLong
     *
     * @return Observation
     */
    public function setGpsLong($gpsLong)
    {
        $this->gpsLong = $gpsLong;

        return $this;
    }

    /**
     * Get gpsLong
     *
     * @return string
     */
    public function getGpsLong()
    {
        return $this->gpsLong;
    }

    /**
     * Set gpsLat
     *
     * @param string $gpsLat
     *
     * @return Observation
     */
    public function setGpsLat($gpsLat)
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    /**
     * Get gpsLat
     *
     * @return string
     */
    public function getGpsLat()
    {
        return $this->gpsLat;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Observation
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return Observation
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set user
     *
     * @param \PiupiuBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\PiupiuBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PiupiuBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set bird
     *
     * @param \PiupiuBundle\Entity\Bird $bird
     *
     * @return Observation
     */
    public function setBird(\PiupiuBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \PiupiuBundle\Entity\Bird
     */
    public function getBird()
    {
        return $this->bird;
    }
}
