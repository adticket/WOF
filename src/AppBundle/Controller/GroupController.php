<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\Restaurant;
use AppBundle\Form\GroupType;
use AppBundle\Form\MeetingType;
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

            return $this->redirectToRoute('group_view');
        }

        return $this->render('group/create.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @Route("/group/view", name="group_view")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function viewAction(EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:Group');
        $groups = $repository->findAll();

        $userGroupIds = $this->getUser()->getGroups()->map(function ($entity) {
            return $entity->getId();
        });

        return $this->render('group/view.html.twig', [
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

        return new RedirectResponse($this->generateUrl('group_view'));
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

        return new RedirectResponse($this->generateUrl('group_view'));
    }

    /**
     * @Route("/group/details/{group}", name="group_details")
     * @param Group $group
     * @return string
     */
    public function detailsAction(Group $group, EntityManagerInterface $em)
    {
        if ($this->isUserInGroup($group)) {
            $meetings = $group->getMeeting();

            return $this->render('group/details.html.twig', [
                "group" => $group,
                "meetings" => $meetings,
            ]);
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));

    }

    /**
     * @Route("/group/restaurants/list/{group}", name="group_listRestaurant")
     * @param Group $group
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function listRestaurantInGroupAction(Group $group, EntityManagerInterface $em)
    {
        if ($this->isUserInGroup($group)) {
            $repository = $em->getRepository('AppBundle:Group');
            $restaurants = $repository->getAllRestaurantInCityofGroup($group, $em);

            return $this->render(':group:list_in_group.html.twig', [
                "restaurants" => $restaurants,
                "group" => $group,
            ]);
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));

    }

    /**
     * @Route("/group/restaurants/add/{group}/{restaurant}", methods={"GET"}, name="group_addRestaurant")
     * @param Group $group
     * @param Restaurant $restaurant
     * @return RedirectResponse
     */
    public function addRestaurantAction(Restaurant $restaurant, Group $group)
    {
        if ($this->isUserInGroup($group)) {
            $group->addRestaurant($restaurant);
            $this->getDoctrine()->getManager()->flush();
            return new RedirectResponse($this->generateUrl('group_listRestaurant', ['group' => $group->getId()]));
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));
    }

    /**
     * @Route("/group/restaurants/remove/{group}/{restaurant}", methods={"GET"}, name="group_removeRestaurant")
     * @param Restaurant $restaurant
     * @param Group $group
     * @return RedirectResponse
     */
    public function removeRestaurantAction(Restaurant $restaurant, Group $group)
    {
        if ($this->isUserInGroup($group)) {
            $group->removeRestaurant($restaurant);
            $this->getDoctrine()->getManager()->flush();
            return new RedirectResponse($this->generateUrl('group_listRestaurant', ['group' => $group->getId()]));
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));

    }

    /**
     * @Route("/group/delete/{group}", methods={"GET"}, name="group_delete")
     * @param Group $group
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function deleteGroupAction(Group $group, EntityManagerInterface $em)
    {
        if ($this->isUserInGroup($group) && $group->getUsers()->count() === 1)
            {
                $em->remove($group);
                $em->flush();
                return new RedirectResponse($this->generateUrl('group_view'));
            }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));

    }

    /**
     * @Route("/group/roll/{group}", methods={"GET"}, name="group_roll")
     * @param Group $group
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function rollAction(Group $group, EntityManagerInterface $em)
    {
        if ($this->isUserInGroup($group)) {

            //if no restaurants in the group, error!
            if ($group->getRestaurants()->count() === 0 )
            {
                $this->addFlash('error', 'Keine Restaurants in der Gruppe!');

                return new RedirectResponse($this->generateUrl('group_details', ['group' => $group->getId()]));
            }

            //generate random int
            $random = rand(0,$group->getRestaurants()->count()-1);

            //get all restaurants of the group
            $restaurants = $group->getRestaurants();

            //decide or just random? do it here!
            $restaurant = $restaurants[$random];

            return $this->render(':group:roll.html.twig', [
                'group' => $group,
                'restaurant' => $restaurant->getname(),
            ]);
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));
    }

    /**
     * @Route("/group/meeting/{group}", name="group_meeting")
     * @param Group $group
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function meetingAction(Group $group, EntityManagerInterface $em, Request $request)
    {
        if ($this->isUserInGroup($group)) {

            //if no restaurants in the group, error!
            if ($group->getRestaurants()->count() === 0 )
            {
                $this->addFlash('error', 'Keine Restaurants in der Gruppe!');

                return new RedirectResponse($this->generateUrl('group_details', ['group' => $group->getId()]));
            }

            $meeting = new Meeting();
            $meeting->setGroup($group);

            $form = $this->createForm(MeetingType::class, $meeting);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                //TODO Send Mail to all UserInGroup

                $em = $this->getDoctrine()->getManager();
                $em->persist($meeting);
                $em->flush();

                return new RedirectResponse($this->generateUrl('group_details', ['group' => $group->getId()]));
            }

            return $this->render(':group:meeting.html.twig', [
                'group' => $group,
                'form' => $form->createView(),
            ]);
        }

        $this->addFlash('error', 'Du kleiner Schlingel hast keine Erlaubnis dies zu tun!');

        return new RedirectResponse($this->generateUrl('group_view'));
    }

    /* public function createAction(Request $request)
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

            return $this->redirectToRoute('group_view');
        }

        return $this->render('group/create.html.twig', ['form' => $form->createView(),]);
    }
     *
    */

    /**
     * Check if the current user is in the given group
     * @param Group $group
     * @return bool
     */
    private function isUserInGroup(Group $group)
    {
        if ($group->getUsers()->contains($this->getUser())) {
            return true;
        }

        return false;
    }

}
