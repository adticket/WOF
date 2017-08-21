<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->find($this->getUser());

        $repository = $this->getDoctrine()->getRepository('AppBundle:Meeting');
        $meetings = $repository->getAllMeetingsOfUser($this->getUser());

        return $this->render('default/index.html.twig', [
            'user' => $user,
            'meetings' => $meetings,
        ]);
    }

    /**
     * Just for testing new mails
     *
     * @Route("/test/mail", name="test_mail")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testMailAction()
    {
        $transport = \Swift_SmtpTransport::newInstance()
        ->setUsername('mitesserportal@gmail.com')
        ->setPassword('portalpassword')
        ->setHost('smtp.gmail.com')
        ->setPort('587')// 587 for tls
        ->setEncryption('tls');

        //Create Message
        $message = (new \Swift_Message())
            ->setSubject('Der Title ist einzigartig!')
            ->setFrom('mitesserportal@gmail.com')
            ->setTo('Domenic.Gerhold@reservix.de')
            ->setReplyTo('domenic.gerhold@reservix.de')
            ->setBody(
                $this->renderView(
                    ':mail:test.html.twig'
                ),
                'text/html'
            );

        //Send Mail
        $mailer = new \Swift_Mailer($transport);
        $mailer->send($message);

        return $this->forward('AppBundle:Default:index');
    }
}