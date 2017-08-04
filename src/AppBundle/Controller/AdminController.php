<?php
/**
 * Created by PhpStorm.
 * User: it-entwicklung
 * Date: 25.07.17
 * Time: 15:59
 */

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/view", name="admin_view")
     */
    public function listAction(EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->findAll();


        return $this->render(':admin:view.html.twig', [
            "users" => $users,
        ]);
    }

}