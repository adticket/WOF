<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Form\GroupCreateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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

        return $this->render('group/add.html.twig',['form' => $form->createView(),]);
    }

    /**
     * @Route("/group/list", name="group_list")
     */
    public function listAction()
    {

        return $this->render('group/list.html.twig');
    }
}