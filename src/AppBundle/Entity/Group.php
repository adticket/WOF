<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
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

    /* doesn't work -> get a exceptionionionion
     * @var string
     *
     * @ORM\Column(unique=true)

    protected $name;
    */

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
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
     * Many Group has Many Locations!
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Location", mappedBy="group")
     */
    private $locations;

    /**
     * Many Groups have Many Users!
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="groups")
     */
    private $users;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->locations = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @return User|string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @return Group
     */
    public function setDeletedAt()
    {
        $this->deleted_at = new \DateTime();
        
        return $this;
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


}