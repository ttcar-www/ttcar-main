<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Security\AppCustomAuthenticator;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppCustomAuthenticator $authenticator
     * @return Response
     * @throws Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppCustomAuthenticator $authenticator): Response
    {
        $date = new DateTime('@'.strtotime('now'));

        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setCreateAt($date);
            $user->setIsVerified(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

      /*      // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('ttcar@ttcar.com', 'Admin Mail bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email*/

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
      * @Route("/verify/email", name="app_verify_email")
      */
    /*
 public function verifyUserEmail(Request $request): Response
 {
     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

     // validate email confirmation link, sets User::isVerified=true and persists
     try {
         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
     } catch (VerifyEmailExceptionInterface $exception) {
         $this->addFlash('verify_email_error', $exception->getReason());

         return $this->redirectToRoute('app_register');
     }

     // @TODO Change the redirect on success and handle or remove the flash message in your templates
     $this->addFlash('success', 'Your email address has been verified.');

     return $this->redirectToRoute('app_register');
 }  */
}
