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
    #[Route('/')]
    public function index(NasaApi $api)
    {
        $objs = ($api->getPictureOfDay());

        return $this->render('base.html.twig',  ['objs'=>$objs]);
    }
}