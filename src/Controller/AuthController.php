<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\LoginType;
use App\Form\Type\RegisterType;
use App\Service\NasaApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class AuthController extends AbstractController
{

    function register(Request $req, UserPasswordHasherInterface  $ph, EntityManagerInterface $em): Response
    {
        $auth = new User();
        $form = $this->createForm(RegisterType::class, $auth);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $hashedPassword = $ph->hashPassword(
                $auth,
                $auth->getPassword()
            );
            $auth->setPassword($hashedPassword);
            $em->persist($auth);
            $em->flush();
            return $this->redirect('/');
        }
        return $this->render('register.html.twig', ['form'=>$form->createView()]);
    }
    #[Route('/login', name: 'app_login')]
    function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('index.html.twig', [
            'error'         => $error,
        ]);
    }

}