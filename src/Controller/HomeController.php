<?php

namespace App\Controller;

use App\Services\DatabaseService;
use App\Services\NasaApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    #[Route("/")]
    public function welcome(): Response
    {
        return $this->render("welcome_page.html.twig");
    }

    #[Route('/homepage')]
    public function homepage(NasaApiService $nasaApiService, EntityManagerInterface $em, DatabaseService $databaseService): Response
    {

        // TODO: $values = $nasaApiService->getAllRovers();

        $values = json_decode(file_get_contents("C:\\Users\\Dulat\\Documents\\GitHub\\exNasaApp\\values.json"), true)["rovers"];

        $databaseService->updateDatabase($values, $em);
        return $this->render("base.html.twig");

    }
}