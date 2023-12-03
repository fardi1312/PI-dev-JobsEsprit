<?php

namespace App\Controller;

use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    


    #[Route('/listCandid', name: 'list_candid')]
    public function listCandidature(CandidatureRepository $Candidaturerepository): Response
    {
    
        return $this->render('candidature/show.html.twig', [
            'candidatures' => $Candidaturerepository->findAll(),
        ]);
    }


}


