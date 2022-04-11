<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/base', name: 'base')]
    public function index(): Response
    {
        return $this->render('base/accueil.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    #[Route('/accueil', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('base/accueil.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
}
