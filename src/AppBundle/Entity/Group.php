<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Group
 * @UniqueEntity("name", message="Gruppenname schon vergeben!")
 * @package AppBundle\Entity
 * @ORM\Table(name="fos_group")
 * @ORM\Entity()
 */
class Group extends BaseGroup
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\Length(min="4", max="50", minMessage="Zu kurz!", maxMessage="Zu lang!")
     * @ORM\Column(name="description", type="string", length=50)
     */
    private $description;

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
     * Many Groups have Many Users!
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="groups")
     */
    private $users;

    /**
     * Many Groups have/is in One city!
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City", inversedBy="groups")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * One Group has many visits!
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\History", mappedBy="group")
     */
    private $history;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Restaurant", inversedBy="groups")
     * @ORM\JoinTable(name="groups_restaurants")
     */
    private $restaurants;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->city = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->history = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * 
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->changed_at = new \DateTime();

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getChangedAt()
    {
        return $this->changed_at;
    }

    /**
     * @return User|string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $name
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->changed_at = new \DateTime();
        return $this;
    }

    /**
     * @param $user
     * @return $this
     */
    public function setCreatedBy($user)
    {
        $this->created_by = $user;
        return $this;
    }

    /**
     * @param User $user
     *
     * @return Group
     */
    public function addUser(User $user)
    {
        $this->users->add($user);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return Group
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $users
     * @return Group
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }

    /**
     * @param Restaurant $restaurant
     * @return $this
     */
    public function addRestaurant(Restaurant $restaurant)
    {
        if (!$this->getRestaurants()->contains($restaurant)) {
            $this->getRestaurants()->add($restaurant);
        }

        return $this;
    }

    /**
     * @param Restaurant $restaurant
     * @return $this
     */
    public function removeRestaurant(Restaurant $restaurant)
    {
        if ($this->getRestaurants()->contains($restaurant)) {
            $this->getRestaurants()->removeElement($restaurant);
        }

        return $this;
    }


}