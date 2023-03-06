<?php

namespace App\Controller;

use App\Services\DatabaseService;
use App\Services\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeeRoversController extends AbstractController
{
    #[Route('/seerovers', name: 'seerovers')]
    public function getSeeRoversPage(DatabaseService $databaseService, NasaApiService $nasaApiService): Response
    {
        return $this->render('see_rovers.html.twig', ['rovers'=>$databaseService->getAllRovers()]);
    }
}