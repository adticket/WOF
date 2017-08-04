<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Meeting
 *
 * @ORM\Table(name="meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetingRepository")
 */
class Meeting
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
     * Many Visits(Meetings) have one Group!
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group", inversedBy="meeting")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * Many Visits(Meetings) have one Restaurant!
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Restaurant", inversedBy="meeting")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    private $restaurant;

    /**
     * @var \DateTime
     * @Assert\DateTime(message="Ungültig!")
     * @Assert\Range(
     *     min="now", max="+6 months",
     *     minMessage="Termin muss in der Zukunft sein!",
     *     maxMessage="Du kannst max. 6 Monate voraus einen Termin erstellen"
     * )
     * @ORM\Column(name="visit_at", type="datetime")
     */
    private $visitAt;


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
     * Set visitAt
     *
     * @param \DateTime $visitAt
     *
     * @return Meeting
     */
    public function setVisitAt($visitAt)
    {
        $this->visitAt = $visitAt;

        return $this;
    }

    /**
     * Get visitAt
     *
     * @return \DateTime
     */
    public function getVisitAt()
    {
        return $this->visitAt;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     * @return Meeting
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * @param mixed $restaurant
     * @return Meeting
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;
        return $this;
    }
}

