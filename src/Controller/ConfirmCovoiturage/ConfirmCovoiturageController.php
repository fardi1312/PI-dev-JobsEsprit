<?php

namespace App\Controller\ConfirmCovoiturage;
use App\Entity\Covoiturage;
use App\Repository\ConfirmCovoiturageRepository;
use App\Entity\ConfirmCovoiturage;
use App\Form\ConfirmCovoiturageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface; 
use Symfony\Component\Mime\Email; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Snappy\Pdf;


#[Route('/confirmcovoiturage')]
class ConfirmCovoiturageController extends AbstractController

{
    private $mailer;
    private $pdf;
    private $pdfOutputPath;  // Define the output path for PDF


    

    public function __construct(MailerInterface $mailer, Pdf $pdf)
    {
        $this->mailer = $mailer;
        $this->pdf = $pdf;
        $this->pdfOutputPath = 'C:\Users\MAS3OUD\Desktop\PIpdf';
    }
    

    #[Route('/listResv', name: 'app_confirm_covoiturage_index', methods: ['GET'])]
    public function index(ConfirmCovoiturageRepository $confirmCovoiturageRepository, SessionInterface $session): Response
    {
        $user = $session->get('user');
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $confirmCovoiturages = $confirmCovoiturageRepository->findAll(); 
        $filteredConfirmCovoiturages = array_filter($confirmCovoiturages, function ($confirmCovoiturage) use ($user) {
            return $confirmCovoiturage->getUsernameEtud() === $user->getUsername();
        });
        return $this->render('confirm_covoiturage/indexEtud.html.twig', [
            'confirm_covoiturages' => $filteredConfirmCovoiturages,
        ]);
    }


    

    #[Route('/listCond', name: 'app_confirm_covoiturage_indexCond', methods: ['GET'])]
    public function indexConfirm(ConfirmCovoiturageRepository $confirmCovoiturageRepository, SessionInterface $session): Response
    {
        $user = $session->get('user');
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $confirmCovoiturages = $confirmCovoiturageRepository->findAll();
        $filteredConfirmCovoiturages = array_filter($confirmCovoiturages, function ($confirmCovoiturage) use ($user) {
            return $confirmCovoiturage->getUsernameConducteur() === $user->getUsername();
        });
        return $this->render('confirm_covoiturage/index.html.twig', [
            'confirm_covoiturages' => $filteredConfirmCovoiturages,
        ]);
    }

    #[Route('/new/{id}', name: 'app_confirm_covoiturage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionInterface $session, $id): Response
    {
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
    
            return $this->redirectToRoute('app_confirm_covoiturage_indexCond', [], Response::HTTP_SEE_OTHER);
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


    #[Route('/showCond/{id}', name: 'app_confirm_covoiturage_show', methods: ['GET'])]
    public function show(ConfirmCovoiturage $confirmCovoiturage): Response
    {
        return $this->render('confirm_covoiturage/showbyid.html.twig', [
            'confirm_covoiturage' => $confirmCovoiturage,
        ]);
    }

    #[Route('/showEtud/{id}', name: 'app_confirm_covoiturage_show1', methods: ['GET'])]
    public function show1(ConfirmCovoiturage $confirmCovoiturage): Response
    {
        return $this->render('confirm_covoiturage/show.html.twig', [
            'confirm_covoiturage' => $confirmCovoiturage,
        ]);
    }



    #[Route('/confirm_reservation/{id}', name: 'confirm_reservation', methods: ['GET', 'POST'])]
    public function confirmReservation($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $confirmCovoiturage = $entityManager->getRepository(ConfirmCovoiturage::class)->find($id);
        if (!$confirmCovoiturage) {
            $this->addFlash('error', 'Confirmation already completed');
            return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
        }

        // Check if already confirmed
        if ($confirmCovoiturage->isConfirmed()) {
            $this->addFlash('error', 'Confirmation already completed');
            return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
        }

        $covoiturage = $confirmCovoiturage->getIdCovoiturage();
        $newAvailableSeats = $covoiturage->getNombrePlacesDisponible() - $confirmCovoiturage->getNombrePlacesReserve();
        $covoiturage->setNombrePlacesDisponible($newAvailableSeats);
        // Set the confirmation status to true
        $confirmCovoiturage->setConfirmed(true);
        $entityManager->persist($covoiturage);
        $entityManager->persist($confirmCovoiturage);
        $entityManager->flush();

        // Generate PDF
        $html = $this->renderView('confirm_covoiturage/confirmation.html.twig', ['confirmation' => $confirmCovoiturage]);
        $outputPath = $this->pdfOutputPath . '/confirmation_' . $id . '.pdf'; // Adjust the filename as needed
        $this->pdf->generateFromHtml($html, $outputPath);

        // Send confirmation email with PDF attachment
        $this->sendConfirmationEmail($confirmCovoiturage, $outputPath);

        // Redirect to the appropriate route after confirmation
        return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
    }

    private function sendConfirmationEmail(ConfirmCovoiturage $confirmation, string $pdfPath) : void
    {
        $email = (new Email())
            ->from('test.pidev123@gmail.com')
            ->to('masoud.ozel.5@gmail.com')
            ->subject('Covoiturage Confirmation')
            ->html($this->renderView('confirm_covoiturage/confirmation.html.twig', ['confirmation' => $confirmation]))
            ->attachFromPath($pdfPath);     
        $this->mailer->send($email);
    }
}


