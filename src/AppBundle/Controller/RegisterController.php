<?php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/login/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->sendRegisterInfo($user);

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'login/register.html.twig', [
                'form' => $form->createView(),
                ]);
    }

    /**
     * Send the information for a successfull registration
     *
     * @param User $user
     */
    private function sendRegisterInfo(User $user)
    {
        $transport = \Swift_SmtpTransport::newInstance()
            ->setUsername('mitesserportal@gmail.com')
            ->setPassword('portalpassword')
            ->setHost('smtp.gmail.com')
            ->setPort('587')// 587 for tls
            ->setEncryption('tls');

        //Create Message
        $message = (new \Swift_Message())
            ->setSubject('Registrierung war erfolgreich!')
            ->setFrom('mitesserportal@gmail.com')
            ->setTo($user->getEmail())
            ->setReplyTo('domenic.gerhold@reservix.de')
            ->setBody(
                $this->renderView(
                    ':mail:registerInfo.html.twig',
                    [
                        'username'  => $user->getUsername(),
                    ]
                ),
                'text/html'
            );

        //Send Mail
        $mailer = new \Swift_Mailer($transport);
        $mailer->send($message);

        return;
    }

}