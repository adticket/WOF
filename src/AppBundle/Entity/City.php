<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(name="cityName", type="string", length=255, unique=true)
     */
    private $cityName;

    /**
     * One City has Many Groups
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Group", mappedBy="locations")
     */
    private $groups;

    /**
     * One City has Many Restaurants!
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Restaurant", mappedBy="city")
     */
    private $restaurant;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->restaurant = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param Group $group
     * @return City
     */
    public function addGroup(Group $group)
    {
        $this->groups->add($group);

        return $this;
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
     * Set cityName
     *
     * @param string $cityName
     *
     * @return City
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }
}

