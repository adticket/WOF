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
     * @Route("/restaurant/view", name="restaurant_view")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:City');
        $cities = $repository->findAll();

        $restaurants = [];
        $repository = $em->getRepository('AppBundle:Restaurant');
        foreach ($cities as $city) {
            $cityRestaurants = $repository->findBy(["city" => $city]);
            if ($cityRestaurants) {
                $restaurants[] = $cityRestaurants;
            }
        }

        $userGroupIds = $this->getUser()->getGroups()->map(function ($entity) {
            return $entity->getId();
        });

        return $this->render('restaurant/view.html.twig', [
            "restaurants" => $restaurants,
            "groups_for_user" => $userGroupIds,
        ]);
    }

    /**
     * @Route("/restaurant/add", name="restaurant_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurant);
            $em->flush();

            return $this->redirectToRoute('restaurant_view');
        }


        return $this->render('restaurant/add.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @Route("/restaurant/edit/{restaurant}", methods={"GET", "POST"}, name="restaurant_edit")
     * @param Request $request
     * @param Restaurant $restaurant
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Restaurant $restaurant)
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //TODO Suche alle Gruppen mit diesem Restaurant und schaue ob die Standorte passen, wenn nicht, entferne dieses Restaurant von der Gruppe!!!


            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('restaurant_view');
        }

        return $this->render('restaurant/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}