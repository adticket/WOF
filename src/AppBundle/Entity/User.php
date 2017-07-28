<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * One User has Many Ratings!
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rating", mappedBy="user")
     */
    private $rating;


    /**
     * Many Users have Many Groups!
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    public function __construct()
    {
        $this->enabled = true;
        $this->roles = ['ROLE_USER'];
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->groups = new ArrayCollection();
        $this->rating = new ArrayCollection();
    }

    public function getRolesPlain()
    {
        return $this->roles;
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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        return array_unique($roles);
    }


}