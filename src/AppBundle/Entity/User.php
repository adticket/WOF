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
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Many Users have Many Groups!
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    public function __construct()
    {
        $this->enabled = true;
        $this->roles = ['ROLE_USER',];
        $this->created_at = new \DateTime();
        $this->changed_at = new \DateTime();
        $this->groups = new ArrayCollection();
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime
     *
     * @return User
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

    public function getGroupIds()
    {
        var_dump(get_current_user());
    }

}