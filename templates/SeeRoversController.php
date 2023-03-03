<?php

namespace templates;

use App\Services\DatabaseService;
use App\Services\NasaApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeeRoversController extends AbstractController
{
    #[Route('/see-rovers', name: 'see-rovers')]
    public function getSeeRoversPage(DatabaseService $databaseService, NasaApiService $nasaApiService): Response
    {
        $databaseService->updateDatabase($nasaApiService->getAllRovers());
        return $this->render('see_rovers.html.twig', ['rovers'=>$databaseService->getAllRovers()]);
    }
}