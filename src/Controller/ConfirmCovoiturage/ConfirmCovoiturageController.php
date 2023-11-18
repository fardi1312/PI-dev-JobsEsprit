<?php

namespace App\Controller\ConfirmCovoiturage;
use App\Entity\Covoiturage;

use App\Entity\ConfirmCovoiturage;
use App\Form\ConfirmCovoiturageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/confirmcovoiturage')]
class ConfirmCovoiturageController extends AbstractController
{
    #[Route('/list', name: 'app_confirm_covoiturage_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $confirmCovoiturages = $entityManager
            ->getRepository(ConfirmCovoiturage::class)
            ->findAll();

        return $this->render('confirm_covoiturage/index.html.twig', [
            'confirm_covoiturages' => $confirmCovoiturages,
        ]);
    }



    #[Route('/new/{id}', name: 'app_confirm_covoiturage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionInterface $session, $id): Response
    {
        // Assuming you have a repository for your Covoiturage entity
        $covoiturage = $entityManager->getRepository(Covoiturage::class)->find($id);
    
        if (!$covoiturage) {
            throw $this->createNotFoundException('Covoiturage not found');
        }

        $userEtud = $session->get('user');

//////////////////////////chmps de Conducteur////////////////////////////

        $confirmCovoiturage = new ConfirmCovoiturage();
        $confirmCovoiturage->setIdCovoiturage($covoiturage); // Assuming you have a setIdCovoiturage method in ConfirmCovoiturage entity
        $confirmCovoiturage->setUsernameConducteur($covoiturage->getUsername()); // Set usernameConducteur
        $confirmCovoiturage->setHeureDepart($covoiturage->getHeuredepart()); // Set heureDepart
        $confirmCovoiturage->setLieuDepart($covoiturage->getLieudepart()); // Set lieuDepart
        $confirmCovoiturage->setLieuArrivee($covoiturage->getLieuarrivee()); // Set lieuArrivee
        $confirmCovoiturage->setnombrePlacesReserve($covoiturage->getnombreplacesdisponible());
        $prix = $covoiturage->getPrix();
        $nbrDespo = $covoiturage->getnombreplacesdisponible();

        $userEtudiant = $covoiturage->getIdUserEtudiant();
        if ($userEtudiant) {
            $confirmCovoiturage->setFirstNameConducteur($userEtudiant->getNom()); // Set firstNameConducteur
            $confirmCovoiturage->setLastNameConducteur($userEtudiant->getPrenom()); // Set lastNameConducteur
            $confirmCovoiturage->setPhoneConducteur($userEtudiant->getPhone()); // Set phoneConducteur
            $confirmCovoiturage->setEmailConducteur($userEtudiant->getEmail()); // Set emailConducteur
        }
//////////////////////////chmps de etudiant////////////////////////////
        if ($userEtud) {
        $confirmCovoiturage->setUsernameEtud($userEtud->getUsername()); // set  usernameEtud
        $confirmCovoiturage->setFirstNameEtud($userEtud->getNom()); // Set firstNameEtud
        $confirmCovoiturage->setLastNameEtud($userEtud->getPrenom()); // Set lastNameEtud
        $confirmCovoiturage->setPhoneEtud($userEtud->getPhone()); // Set phoneEtud
        $confirmCovoiturage->setEmailEtud($userEtud->getEmail());
        }
///////////////////////////////////////////////////////////////////
 
    
        $form = $this->createForm(ConfirmCovoiturageType::class, $confirmCovoiturage, [
            'nbrDespo' => $nbrDespo,
            'prix' =>  $prix,
        ]);  

         $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($confirmCovoiturage);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_confirm_covoiturage_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('confirm_covoiturage/new.html.twig', [
            'confirm_covoiturage' => $confirmCovoiturage,
            'form' => $form,
            'prix' =>  $prix,
            'nbrDespo' => $nbrDespo,
        ]);
    }
    


    #[Route('/{id}/edit', name: 'app_confirm_covoiturage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConfirmCovoiturage $confirmCovoiturage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConfirmCovoiturageType::class, $confirmCovoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_confirm_covoiturage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('confirm_covoiturage/edit.html.twig', [
            'confirm_covoiturage' => $confirmCovoiturage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_confirm_covoiturage_delete', methods: ['POST'])]
    public function delete(Request $request, ConfirmCovoiturage $confirmCovoiturage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$confirmCovoiturage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($confirmCovoiturage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_confirm_covoiturage_index', [], Response::HTTP_SEE_OTHER);
    }
}


