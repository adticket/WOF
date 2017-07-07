<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="category_name", type="string", length=50)
     */
    private $categoryName;

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
     * Many Categories has many Locations
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Location", mappedBy="categories")
     */
    private $locations;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->created_by = get_current_user();
        $this->locations = new ArrayCollection();
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
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
        $this->changed_at = new \DateTime();

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
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
     * @return Category
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
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param ArrayCollection $locations
     *
     * @return Category
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;

        return $this;
    }

    /**
     * @param Location $location
     *
     * @return Category
     */
    public function addLocation(Location $location)
    {
        $this->locations->add($location);

        return $this;
    }
}

