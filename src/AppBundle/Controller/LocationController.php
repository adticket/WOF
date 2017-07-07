<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LocationController
 * @package AppBundle\Controller
 */
class LocationController extends Controller
{
    /**
     * @Route("/location/list", name="location_list")
     */
    public function listAction(Request $request)
    {
        return $this->render('location/list.html.twig');
    }

    /**
     * @Route("/location/add", name="location_add")
     */
    public function user_profileAction(Request $request)
    {
        return $this->render('location/add.html.twig',
            ['firstname' => 'Vorname',
                'lastname' => 'Nachname',
                'mail' => 'Email@gmx.de',
                'createDate' => '01.01.2007']);
    }
}