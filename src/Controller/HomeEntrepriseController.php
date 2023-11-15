<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeEntrepriseController extends AbstractController
{
    #[Route('/home/entreprise', name: 'app_home_entreprise')]
    public function index(): Response
    {
        return $this->render('dashboard.html.twig', [
            'controller_name' => 'HomeEntrepriseController',
        ]);
    }
}
