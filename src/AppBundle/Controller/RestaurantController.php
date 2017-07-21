<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Restaurant;
use AppBundle\Form\RestaurantType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class RestaurantController
 * @package AppBundle\Controller
 */
class RestaurantController extends Controller
{
    /**
     * @Route("/restaurant/list", name="restaurant_list")
     */
    public function listAction(Request $request, EntityManagerInterface $em)
    {

        $repository = $em->getRepository('AppBundle:Restaurant');
        $restaurants = $repository->findAll();

        $userGroupIds = $this->getUser()->getGroups()->map(function ($entity) {
            return $entity->getId();
        });

        return $this->render('restaurant/list.html.twig', [
            "restaurants" => $restaurants,
            "groups_for_user" => $userGroupIds,
        ]);
    }

    /**
     * @Route("/restaurant/add", name="restaurant_add")
     */
    public function user_profileAction(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurant);
            $em->flush();

            return $this->redirectToRoute('restaurant_list');
        }


        return $this->render('restaurant/add.html.twig',['form' => $form->createView(),]);
    }
}

/*
 * $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_list');
        }


        return $this->render('/category/add.html.twig',['form' => $form->createView(),]);
 */