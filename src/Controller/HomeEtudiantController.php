<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface; // Assurez-vous d'avoir cette ligne ajoutée

class HomeEtudiantController extends AbstractController
{
    #[Route('/home/etudiant', name: 'app_home_etudiant')]
    public function index(SessionInterface $session): Response
    {
        // Récupérer les données de l'utilisateur depuis la session
        $user = $session->get('user');
        return $this->render('baseEtudiant.html.twig', [
            'user' => $user,
            'user' => $user,
        ]);
    }




}
