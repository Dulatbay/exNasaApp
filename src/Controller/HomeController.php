<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Post;
use App\Form\Type\PostType;
use App\Repository\RoverRepository;
use App\Services\DatabaseService;
use App\Services\FileUploader;
use App\Services\NasaApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route("/")]
    public function welcome(): Response
    {
        $req = Request::createFromGlobals();
        dump($req);
        return $this->render("welcome_page.html.twig");
    }

    #[Route('/homepage', name: 'app_homepage')]
    public function homepage(Request $req, DatabaseService $databaseService): Response
    {
        $posts = $databaseService->getAllPosts();
        return $this->render("homepage.html.twig", ['posts' => $posts]);
    }
    #[Route('/apods')]
    public function apods(Request $req, NasaApiService $nasaApiService): Response
    {
        $apods = $nasaApiService->getPictureOfDay();
        return $this->render("apods.html.twig", ['apods' => $apods]);
    }
}