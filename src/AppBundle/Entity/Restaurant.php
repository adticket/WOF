<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Restaurant
 * @package AppBundle\Entity
 * @ORM\Table(name="restaurant")
 * @ORM\Entity()
 */
class Restaurant
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
     *     pattern     = "/^[a-z0-9öäüß&'\. ]+$/i",
     *     htmlPattern = "^[a-zA-Z0-9öäüßÖÄÜ&\. ]+$",
     *     message="Nur . oder Buchstaben oder Zahlen!"
     * )
     * @Assert\Length(min=3, max=24, minMessage="Name zu kurz!", maxMessage="Name zu lang!")
     *
     * @ORM\Column(name="restaurant_name", type="string")
     */
    private $name;

    /**
     * @var string
     * @Assert\Regex(
     *      pattern="/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i",
     *      htmlPattern="^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$",
     *      message = "Die URL '{{ value }}' ist nicht korrekt!",
     * )
     * @ORM\Column(name="website", type="string", nullable=true)
     */
    private $website;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern     = "/^[a-zöäüß\.\- ]+$/i",
     *     htmlPattern = "^[a-zA-ZöäüßÖÄÜ\.\- ]+$",
     *     message="Nur . oder Buchstaben!"
     * )
     * @Assert\Length(min=3, max=24, minMessage="Name zu kurz!", maxMessage="Name zu lang!")
     * @ORM\Column(name="street", type="string", length=100, nullable=true)
     */
    private $street;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern     = "/[0-9]+[ \-]?[a-z]?$/i",
     *     htmlPattern = "^[0-9]+[ \-]?[a-zA-Z]?$",
     *     message="Ungültige Hausnummer!"
     * )
     * @Assert\Length(min="1", max="10", maxMessage="Zu lang", minMessage="Bitte eintragen")
     * @ORM\Column(name="house_no", type="string", length=10, nullable=true)
     */
    private $house_no;
    // Der Check (Assert) der Hausnummer ist nicht korrekt!
    // Er wird nicht richtig angezeigt und funktioniert auch nicht gut!

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
     * Many Restaurants has Many Categories
     * @var ArrayCollection
     * @Assert\Count(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Wähle mind. eine Kategorie, max. fünf",
     *      maxMessage = "Wähle max. fünf Kategorien, mind. eine"
     * )
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="restaurants")
     * @ORM\JoinTable(name="restaurant_category")
     */
    private $categories;

    /**
     * Many Restaurants have/are in one City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City", inversedBy="restaurants")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @var City
     */
    private $city;

    /**
     * One Restaurant has Many visits!
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\History", mappedBy="restaurant")
     */
    private $history;
    /**
     * One Restaurant has Many Meetings!
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Meeting", mappedBy="restaurant")
     */
    private $meeting;

    /**
     * One Restaurant has Many Ratings!
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rating", mappedBy="restaurant")
     */
    private $rating;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", mappedBy="restaurants")
     */
    private $groups;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->categories = new ArrayCollection();
        $this->history = new ArrayCollection();
        $this->rating = new ArrayCollection();
        $this->groups = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return restaurant
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->changed_at = new \DateTime();

        return $this;
    }

    /**
     * Get restaurantName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set homepage
     *
     * @param string $website
     *
     * @return Restaurant
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
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     *
     * @return Restaurant
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param $category
     *
     * @return Restaurant
     */
    public function addCategory($category)
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHouseNo()
    {
        return $this->house_no;
    }

    /**
     * @param $house_no
     */
    public function setHouseNo($house_no)
    {
        $this->house_no = $house_no;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return Restaurant
     */
    public function setCity(City $city)
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
     * @param ArrayCollection $history
     * @return Restaurant
     */
    public function setHistory($history)
    {
        $this->history = $history;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param Rating $rating
     * @return Restaurant
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Give back the ready google maps link of a restaurant!
     *
     * @return mixed|string
     */
    public function genMapsLink()
    {
        $city = str_replace(' ', '+', $this->getCity()->getCityName());
        $street = str_replace(' ', '+', $this->getStreet());
        $hno = str_replace(' ', '+', $this->getHouseNo());

        $url = "https://maps.google.com?q=" . $city . '+' . $street . '+' . $hno;

        return $url;
    }


}

