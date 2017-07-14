<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\Location;
use AppBundle\Form\GroupCreateType;
use AppBundle\Form\LocationType;
use Doctrine\Common\Util\Debug;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $form = $this->createForm(GroupCreateType::class, $group);

        // 2) handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //3.1 add the creater in the pivot table
            $user = $this->getUser();
            $user->addGroup($group);

            //3.2 set the creater in the group!
            $group->setCreatedBy($user);

            // 4) Save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('group_list');
        }

        return $this->render('group/create.html.twig',['form' => $form->createView(),]);
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
     * @Route("/group/details/{group}/addlocation", name="group_add_location")
     * @param Request $request
     * @param Group $group
     * @return RedirectResponse|Response
     */
    public function addLocationAction(Request $request, Group $group)
    {
        $location = new Location($group);

        //$form = $this->createForm(LocationType::class, $location);
        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //TODO set the Location Group to the $group
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->render('group/details.html.twig', [
                "group" => $group,
            ]);
        }
        return $this->render(':group:addLocation.html.twig',['form' => $form->createView(),
        'group' => $group]);
    }





}