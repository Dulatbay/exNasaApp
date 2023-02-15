<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\AuthType;
use App\Service\NasaApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class AuthController extends AbstractController
{

    #[Route('/auth/registration')]
    function registration(Request $req, UserPasswordHasherInterface  $ph, EntityManagerInterface $em): Response
    {
        $auth = new User();
        $form = $this->createForm(AuthType::class, $auth);
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
        return $this->render('auth.html.twig', ['form'=>$form->createView()]);
    }
}