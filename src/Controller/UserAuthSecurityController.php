<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class UserAuthSecurityController extends AbstractController
{
    public function __construct()
    {
    }
    #[Route(path: '/register', name: 'app_register')]
    function register(Security $security,Request $req, EntityManagerInterface $em, UserCheckerInterface $checker, UserAuthenticatorInterface $authenticator, UserPasswordHasherInterface $hasher, FormLoginAuthenticator $formLoginAuthenticator): Response
    {
        if($security->getUser()){
            return $this->redirectToRoute('app_homepage');
        }
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $checker->checkPreAuth($user);
            $authenticator->authenticateUser($user, $formLoginAuthenticator, $req);
            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('register.html.twig', ['form' => $form->createView()]);
    }
    #[Route(path: '/register_admin', name: 'admin_app_register')]
    function adminRegister(Security $security,Request $req, EntityManagerInterface $em, UserCheckerInterface $checker, UserAuthenticatorInterface $authenticator, UserPasswordHasherInterface $hasher, FormLoginAuthenticator $formLoginAuthenticator): Response
    {
        if($security->getUser()){
            return $this->redirectToRoute('users-list');
        }
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_USER", "ROLE_ADMIN", "ROLE_MANAGER"]);
            $em->persist($user);
            $em->flush();
            $checker->checkPreAuth($user);

            $authenticator->authenticateUser($user, $formLoginAuthenticator, $req);
            return $this->redirectToRoute('users-list');
        }
        return $this->render('register.html.twig', ['form' => $form->createView()]);
    }
    #[Route(path: '/register_manager', name: 'manager_app_register')]
    function managerRegister(Security $security,Request $req, EntityManagerInterface $em, UserCheckerInterface $checker, UserAuthenticatorInterface $authenticator, UserPasswordHasherInterface $hasher, FormLoginAuthenticator $formLoginAuthenticator): Response
    {
        if($security->getUser()){
            return $this->redirectToRoute('users-list');
        }
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_USER", "ROLE_MANAGER"]);
            $em->persist($user);
            $em->flush();
            $checker->checkPreAuth($user);

            $authenticator->authenticateUser($user, $formLoginAuthenticator, $req);
            return $this->redirectToRoute('users-list');
        }
        return $this->render('register.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/login', name: 'app_login')]
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
