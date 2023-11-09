<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeEtudiantController extends AbstractController
{
    #[Route('/home/etudiant', name: 'app_home_etudiant')]
    public function index(): Response
    {
        return $this->render('baseEtudiant.html.twig', [
            'controller_name' => 'HomeEtudiantController',
        ]);
    }
}
