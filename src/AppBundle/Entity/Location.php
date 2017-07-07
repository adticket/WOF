<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 */
class Location
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
     * @ORM\Column(name="locationName", type="string")
     */
    private $locationName;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=100, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_no", type="string", length=10, nullable=true)
     */
    private $house_no;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="integer", length=6, nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed_at", type="datetime")
     */
    private $changed_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @var User
     *
     * @ORM\Column(name="created_by", type="object")
     */
    private $created_by;

    /**
     * Many Locations have one Group!
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group", inversedBy="locations")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * Many Locations has Many Categories
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="locations")
     * @ORM\JoinTable(name="locations_categories")
     */
    private $categories;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->created_by = get_current_user();
        $this->categories = new ArrayCollection();
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
     * Set locationName
     *
     * @param string $locationName
     *
     * @return Location
     */
    public function setLocationName($locationName)
    {
        $this->locationName = $locationName;
        $this->changed_at = new \DateTime();

        return $this;
    }

    /**
     * Get locationName
     *
     * @return string
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * Set homepage
     *
     * @param string $website
     *
     * @return Location
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        $this->changed_at = new \DateTime();
        return $this;
    }

    /**
     * Get homepage
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->changed_at = new \DateTime();

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get createdBy
     *
     * @return object
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get changedAt
     *
     * @return \DateTime
     */
    public function getChangedAt()
    {
        return $this->changed_at;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime
     *
     * @return Location
     */
    public function setDeletedAt()
    {
        $this->deleted_at = new \DateTime();

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     *
     * @return Location
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param Category $category
     *
     * @return Location
     */
    public function addCategory(Category $category)
    {
        $this->categories->add($category);

        return $this;
    }
}

