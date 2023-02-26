<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserAuthSecurityController extends AbstractController
{
    public function __construct()
    {
    }
    #[Route(path: '/register', name: 'app_register')]
    #[IsGranted('IS_AUTHENTICATED_ANONYMOUSLY')]
    public function register(Request $req, EntityManagerInterface $em, UserCheckerInterface $checker, UserAuthenticatorInterface $authenticator, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $checker->checkPreAuth($user);

            $authenticator->authenticateUser($user, $req);
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('register.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/login', name: 'app_login')]
    #[IsGranted('IS_AUTHENTICATED_ANONYMOUSLY')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
