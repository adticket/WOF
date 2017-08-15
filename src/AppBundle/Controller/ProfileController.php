<?php
namespace AppBundle\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProfileController
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{
    /**
     * @Route("/user/profile", name="user_profile")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function user_profileAction(EntityManagerInterface $em)
    {
        $repository = $em->getRepository('AppBundle:User');
        $user = $repository->find($this->getUser());

        return $this->render('user/profile.html.twig',
            ['user' => $user,]);
    }
}
