<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Useretudiant;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    #[Route('/AddCondid', name: 'Add_candid')]
    public function addCandidature(Request $request, CandidatureRepository $candidatureRepository, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        // Get the user from the session
        $user = $session->get('user');
    
        // Redirect to the login page if the user is not authenticated
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
    
        // Get the Useretudiant entity based on the user ID
        $etudiant = $entityManager->getRepository(Useretudiant::class)->find($user->getId());
    
        // Find or create an Offre entity (adjust based on your Offre entity structure)
    
        // Create a new Candidature entity and associate it with the Useretudiant and Offre
        $candid = new Candidature();
        $candid->setEtudiant($etudiant);
        $candid->setIsTreated(false);
    
        // Dump for debugging purposes
        dump($candid);
    
        return $this->render('offre/test.html.twig', [
            'candidature' => $candid,
        ]);
    }
    



}