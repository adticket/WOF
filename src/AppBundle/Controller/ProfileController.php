<?php
namespace AppBundle\Controller;

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
    public function user_profileAction(Request $request)
    {
        return $this->render('user/profile.html.twig',
            ['firstname' => $this->getUser()->getUsername(),
            'mail' => $this->getUser()->getEmail(),]);
    }
}
