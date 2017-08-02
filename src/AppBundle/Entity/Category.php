<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 * @UniqueEntity("categoryName", message="Diese Kategorie gibt es schon!")
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
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="Nur Buchstaben!"
     * )
     * @Assert\Length(min=3, max=16, minMessage="Name zu kurz!", maxMessage="Name zu lang!")
     * @ORM\Column(name="category_name", type="string", length=50, unique=true)
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
     * @var User
     *
     * @ORM\Column(name="created_by", type="object")
     */
    private $created_by;

    /**
     * Many Categories has many Restaurants
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Restaurant", mappedBy="categories")
     */
    private $restaurants;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->restaurants = new ArrayCollection();
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
     * @return mixed
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }

    /**
     * @param mixed $restaurants
     * @return Category
     */
    public function setRestaurants($restaurants)
    {
        $this->restaurants = $restaurants;
        return $this;
    }

    /**
     * @param Restaurant $restaurant
     *
     * @return Category
     */
    public function addRestaurant(Restaurant $restaurant)
    {
        $this->restaurants->add($restaurant);

        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param User $created_by
     * @return Category
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }


}

