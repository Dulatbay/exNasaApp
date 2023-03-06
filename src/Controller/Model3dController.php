<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Model3dController extends AbstractController
{
    #[Route('/3dModelPage')]
    function getModel3dPage(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('3dModelPage.html.twig');
    }
}