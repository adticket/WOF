<?php
namespace AppBundle\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfileController
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{
    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function user_profileAction(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:User');
        $user = $repository->find($this->getUser());

        return $this->render('user/profile.html.twig',
            ['user' => $user,]);
    }
}
