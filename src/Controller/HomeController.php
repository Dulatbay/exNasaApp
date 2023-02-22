<?php

namespace App\Controller;

use App\Services\NasaApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */

    #[Route("/")]
    public function welcome(): Response
    {
        return $this->render("welcome_page.html.twig");
    }

    #[Route('/homepage')]
    public function homepage(NasaApi $api): Response
    {
        $apods = $api->getPictureOfDay();
        $roverPhotosTmp = (array_slice(array($api->getMarsPhotos()), 0, 3));
        return $this->render('base.html.twig',  ['apods'=>$apods]);
    }
}