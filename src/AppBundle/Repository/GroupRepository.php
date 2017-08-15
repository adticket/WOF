<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GroupRepository
 * @package AppBundle\Repository
 */
class GroupRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Group $group
     * @param EntityManagerInterface $em
     * @return \AppBundle\Entity\Restaurant[]|array
     */
    public function getAllRestaurantInCityofGroup(Group $group, EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:Restaurant');
        $restaurants = $repository->findBy([
            'city' => $group->getCity()->getId(),
        ]);

        return $restaurants;
    }

}
