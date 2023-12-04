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
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\LabelMargin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;


#[Route('/confirmcovoiturage')]
class ConfirmCovoiturageController extends AbstractController

{
    private $mailer;
    private $pdf;
    private $qrCodeBuilder;
    private $pdfOutputPath;

    public function __construct(MailerInterface $mailer, Pdf $pdf, BuilderInterface $qrCodeBuilder)
    {
        $this->mailer = $mailer;
        $this->pdf = $pdf;
        $this->qrCodeBuilder = $qrCodeBuilder;
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
            $confirmCovoiturage->setFirstNameConducteur($userEtudiant->getFirstName()); // Set firstNameConducteur
            $confirmCovoiturage->setLastNameConducteur($userEtudiant->getLastName()); // Set lastNameConducteur
            $confirmCovoiturage->setPhoneConducteur($userEtudiant->getPhone()); // Set phoneConducteur
            $confirmCovoiturage->setEmailConducteur($userEtudiant->getEmail()); // Set emailConducteur
        }
//////////////////////////chmps de etudiant////////////////////////////
        if ($userEtud) {
        $confirmCovoiturage->setUsernameEtud($userEtud->getUsername()); // set  usernameEtud
        $confirmCovoiturage->setFirstNameEtud($userEtud->getFirstName()); // Set firstNameEtud
        $confirmCovoiturage->setLastNameEtud($userEtud->getLastName()); // Set lastNameEtud
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
    public function confirmReservation($id, Request $request, EntityManagerInterface $entityManager, Pdf $pdf, BuilderInterface $qrCodeBuilder): Response
    {
        $confirmCovoiturage = $entityManager->getRepository(ConfirmCovoiturage::class)->find($id);
    
        if (!$confirmCovoiturage) {
            $this->addFlash('error', 'Confirmation already completed');
            return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
        }
    
        // Vérifier si la confirmation a déjà été effectuée
        if ($confirmCovoiturage->isConfirmed()) {
            $this->addFlash('error', 'Confirmation already completed');
            return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
        }
    
        // Générer le QR code
        $qrCodeDataUri = $this->generateQrCodeForConfirmCovoiturage($qrCodeBuilder, $confirmCovoiturage);
    
        // Générer le PDF
        $html = $this->renderView('confirm_covoiturage/confirmation.html.twig', [
            'confirmation' => $confirmCovoiturage,
            'qrCodeDataUri' => $qrCodeDataUri,
        ]);
        $outputPath = $this->pdfOutputPath . '/confirmation_' . $id . '.pdf'; // Ajustez le nom de fichier au besoin
        $pdf->generateFromHtml($html, $outputPath);
    
        // Mettre à jour le statut de confirmation et les données du covoiturage dans la base de données
        $this->updateConfirmationStatusAndCovoiturageData($confirmCovoiturage, $entityManager);
    
        // Envoyer un e-mail de confirmation avec la pièce jointe PDF et le QR code
        $this->sendConfirmationEmail($confirmCovoiturage, $outputPath, $qrCodeDataUri);
    
        // Rediriger vers la route appropriée après la confirmation
        return $this->redirectToRoute('app_confirm_covoiturage_indexCond');
    }
    
    private function generateQrCodeForConfirmCovoiturage(BuilderInterface $qrCodeBuilder, ConfirmCovoiturage $confirmCovoiturage): string
    {
        // Construction du lien direct vers Google Maps en utilisant les noms de lieu
        $googleMapsLink = $this->generateGoogleMapsLink(
            $confirmCovoiturage->getLieuDepart(),
            $confirmCovoiturage->getLieuArrivee()
        );
    
        // Construction du QR code
        $qrCode = $qrCodeBuilder
            ->data($googleMapsLink)
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->margin(10)
            ->build();
    
        // Récupérer les données au format Data URI
        $qrCodeDataUri = $qrCode->getDataUri();
    
        return $qrCodeDataUri;
    }
    
    private function generateGoogleMapsLink($lieuDepart, $lieuArrivee)
    {
        // Formater le lien Google Maps avec les noms des lieux
        $url = "https://www.google.com/maps/dir/{$lieuDepart}/{$lieuArrivee}";
    
        return $url;
    }
    
    private function updateConfirmationStatusAndCovoiturageData(ConfirmCovoiturage $confirmCovoiturage, EntityManagerInterface $entityManager): void
    {
        // Mise à jour du statut de confirmation et des données du covoiturage dans la base de données
        $covoiturage = $confirmCovoiturage->getIdCovoiturage();
        $newAvailableSeats = $covoiturage->getNombrePlacesDisponible() - $confirmCovoiturage->getNombrePlacesReserve();
        $covoiturage->setNombrePlacesDisponible($newAvailableSeats);
        $confirmCovoiturage->setConfirmed(true);
        $entityManager->persist($covoiturage);
        $entityManager->persist($confirmCovoiturage);
        $entityManager->flush();
    }

    private function sendConfirmationEmail(ConfirmCovoiturage $confirmation, string $pdfPath, string $qrCodeDataUri): void
    {
        // Construction du lien direct vers Google Maps en utilisant les noms de lieu
        $googleMapsLink = $this->generateGoogleMapsLink(
            $confirmation->getLieuDepart(),
            $confirmation->getLieuArrivee()
        );
    
        // Création des données à passer au template Twig
        $emailData = [
            'confirmation' => $confirmation,
            'qrCodeDataUri' => $qrCodeDataUri,
            'googleMapsLink' => $googleMapsLink,
        ];
        // Création du corps HTML de l'e-mail
        $emailBody = $this->renderView('confirm_covoiturage/confirmation.html.twig', $emailData);
        // Création de l'e-mail avec le corps HTML
        $email = (new Email())
            ->from('test.pidev123@gmail.com')
            ->to('masoud.ozel.5@gmail.com')
            ->subject('Covoiturage Confirmation')
            ->html($emailBody)
            ->attachFromPath($pdfPath); // Attache le fichier PDF au message
    
        // Envoi de l'e-mail
        $this->mailer->send($email);
    }
    
}