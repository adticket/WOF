<?php
namespace AppBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Form\CityType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CityController
 * @package AppBundle\Controller
 */
class CityController extends Controller
{
    /**
     * @Route("/city/view", name="city_view")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(EntityManagerInterface $em)
    {

        $repository = $em->getRepository('AppBundle:City');
        $city = $repository->findAll();


        return $this->render(':city:view.html.twig', [
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

            return $this->redirectToRoute('city_view');
        }

        return $this->render('/city/add.html.twig',['form' => $form->createView(),]);
    }

    /**
     * @Route("/city//edit/{city}", methods={"GET", "POST"}, name="city_edit")
     * @param Request $request
     * @param City $city
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, City $city)
    {
        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('city_view');
        }

        return $this->render('city/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
