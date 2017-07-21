<?php
namespace AppBundle\Controller;

use AppBundle\Entity\City;

use AppBundle\Form\CityType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CityController
 * @package AppBundle\Controller
 */
class CityController extends Controller
{

    /**
     * @Route("/city/list", name="city_list")
     */
    public function listAction(Request $request, EntityManagerInterface $em)
    {

        $repository = $em->getRepository('AppBundle:City');
        $city = $repository->findAll();


        return $this->render(':city:list.html.twig', [
            "cities" => $city,
        ]);
    }


    /**
     * @Route("/city/add", name="city_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('city_list');
        }


        return $this->render('/city/add.html.twig',['form' => $form->createView(),]);
    }
}
