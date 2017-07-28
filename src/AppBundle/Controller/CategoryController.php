<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;

use AppBundle\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * @Route("/category/view", name="category_view")
     */
    public function viewAction(EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:Category');
        $categories = $repository->findAll();

        $form = $this->createForm(CategoryType::class);


        return $this->render('category/view.html.twig', [
            "categories" => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * -->wird momentan nicht genutzt!
     * @Route("/api/categories/all", name="api_categories_all")
     */
    public function getEntriesAction()
    {
        $entries = $this->get('doctrine')->getManager()->getRepository('AppBundle:Category')->findAll();

        $response = [];

        foreach ($entries as $entry) {
            $response[] = [
                "id" => $entry->getId(),
                "name" => $entry->getCategoryName(),
            ];
        }

        return new JsonResponse(json_encode($response));
    }

    /**
     * @Route("/category/add", name="category_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_view');
        }


        return $this->render('category/add.html.twig', ['form' => $form->createView(),]);
    }
}
