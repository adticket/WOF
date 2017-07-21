<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\Restaurant;
use AppBundle\Form\GroupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class GroupController extends Controller
{
    /**
     * @Route("/group/create", name="group_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        // 1) build the form
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);

        // 2) handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //3.1 add the creater in the pivot table
            $user = $this->getUser();
            $user->addGroup($group);
            $group->setCreatedBy($user);


            // 4) Save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('group_list');
        }

        return $this->render('group/add.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @Route("/group/list", name="group_list")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listAction(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:Group');
        $groups = $repository->findAll();

        $userGroupIds = $this->getUser()->getGroups()->map(function ($entity) {
            return $entity->getId();
        });

        return $this->render('group/list.html.twig', [
            "groups" => $groups,
            "groups_for_user" => $userGroupIds,
        ]);
    }

    /**
     * @Route("/group/join/{group}", methods={"GET"}, name="group_join")
     * @param Group $group
     * @return RedirectResponse
     */
    public function joinAction(Group $group)
    {
        $this->getUser()->addGroup($group);
        $this->getDoctrine()->getManager()->flush();

        return new RedirectResponse($this->generateUrl('group_list'));
    }

    /**
     * @Route("/group/left/{group}", methods={"GET"}, name="group_left")
     * @param Group $group
     * @return RedirectResponse
     */
    public function leftAction(Group $group)
    {
        $this->getUser()->removeGroup($group);
        $this->getDoctrine()->getManager()->flush();

        return new RedirectResponse($this->generateUrl('group_list'));
    }

    /**
     * @Route("/group/details/{group}", name="group_details")
     * @param Group $group
     * @return string
     */
    public function detailsAction(Group $group)
    {
        return $this->render('group/details.html.twig', [
            "group" => $group,
        ]);
    }

    /**
     * @Route("/group/restaurants/list/{group}", name="group_listRestaurant")
     * @param Group $group
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listRestaurantInGroupAction(Group $group, Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:Restaurant');
        $restaurants = $repository->findBy([
            'city' => $group->getCity()->getId(),
        ]);

        return $this->render(':group:list_in_group.html.twig', [
            "restaurants" => $restaurants,
            "group" => $group,
        ]);
    }

    /**
     * @Route("/group/restaurants/add/{group}+{restaurant}", methods={"GET"}, name="group_addRestaurant")
     * @param Group $group
     * @param Restaurant $restaurant
     * @return RedirectResponse
     */
    public function addRestaurantAction(Restaurant $restaurant, Group $group)
    {
        $group->addRestaurant($restaurant);
        $this->getDoctrine()->getManager()->flush();

        return new RedirectResponse($this->generateUrl('group_listRestaurant', ['group' => $group->getId()]));
    }

    /**
     * @Route("/group/restaurants/remove/{group}+{restaurant}", methods={"GET"}, name="group_removeRestaurant")
     * @param Restaurant $restaurant
     * @param Group $group
     * @return RedirectResponse
     */
    public function removeRestaurantAction(Restaurant $restaurant, Group $group)
    {
        $group->removeRestaurant($restaurant);
        $this->getDoctrine()->getManager()->flush();

        return new RedirectResponse($this->generateUrl('group_listRestaurant', ['group' => $group->getId()]));
    }

}