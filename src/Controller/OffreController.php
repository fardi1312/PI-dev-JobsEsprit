<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Entity\Userentreprise;
use App\Entity\Useretudiant;
use App\Form\OffreFormType;
use App\Repository\OffreRepository;
use App\Services\QrcodeService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Dompdf;
use Dompdf\Options;


class OffreController extends AbstractController
{
   
   

    #[Route('/listoffre', name: 'list_offre')]
    public function listBook(OffreRepository $offrerepository): Response
    {

        return $this->render('offre/show.html.twig', [
            'offres' => $offrerepository->findAll(),
        ]);
    }

    #[Route('/home/etudiant', name: 'app_home_etudiant')]

    public function index(OffreRepository $offreRepository): Response
    {
        // Utilisez la méthode du repository pour récupérer les trois offres les plus récentes
        $offres = $offreRepository->findNewestThree();

        return $this->render('baseEtudiant.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/form', name: 'app_form')]
public function showForm(Request $request, EntityManagerInterface $entityManager): Response
{
    // Assuming Entreprise is associated with Offre, adjust this based on your entity relationships
    $entreprise = $entityManager->getRepository(Userentreprise::class)->find(1);

    if (!$entreprise) {
        throw $this->createNotFoundException('Entreprise with ID 1 not found');
    }

    $offre = new Offre();
    $offre->setEntrepriseid($entreprise);

    $form = $this->createForm(OffreFormType::class, $offre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $uploadedFile = $form->get('image')->getData();

        if ($uploadedFile) {
            $imageDirectory = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

            try {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $uploadedFile->move($destination, $newFilename);
            } catch (FileException $e) {
                // Handle the file upload exception
            }

            $offre->setImage('uploads/'.$newFilename);
        }

        $entityManager->persist($offre);
        $entityManager->flush();

        return $this->redirectToRoute('list_offre');
    }

    return $this->render('offre/form.html.twig', [
        'form' => $form->createView(),
    ]);
}


    
    


#[Route('/offre/delete/{id}', name: 'offre_delete')]
public function deleteOffre(Request $request, $id, ManagerRegistry $manager, OffreRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('list_offre');
}
#[Route('/offre/edit/{id}', name: 'edit_offre', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreFormType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('list_offre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/editBook.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }
#[Route('/offre/details/{id}', name: 'offre_details')]
public function show(OffreRepository $offreRepository, $id): Response
{
    return $this->render('offre/showDetails.html.twig', [
        'offre' => $offreRepository->find($id),
    ]);
}

#[Route('/offres', name: 'offres')]
public function showoffres(OffreRepository $offreRepository,): Response
{
    // Utilize the repository method to retrieve all offers
    $offres = $offreRepository->findAll();

    return $this->render('offre/offre.html.twig', [
        'offres' => $offres,
    ]);
}


#[Route('/offre/like/{id}', name: 'like', methods: [ 'POST','GET'])]

public function likeOffre(Offre $offre,EntityManagerInterface $entityManager): Response
{
    $user = $entityManager->getRepository(Useretudiant::class)->find(1);

    if ($offre->getLikes()->contains($user)) {
        $offre->removeLike($user);
    } else {
        $offre->addLike($user);
    }

 
    $entityManager->persist($offre);
    $entityManager->flush();

    return $this->redirectToRoute('offres');
}
#[Route('/offre/generate-pdf/{id}', name: 'generate_pdf', methods: ['GET'])]
public function generatePdf($id, OffreRepository $offreRepository, QrcodeService $qrcodeService): Response
{
    $qrCode = null;
    $offre = $offreRepository->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('Offre not found');
    }

    // Get the UserEntreprise associated with the offer
    $userEntreprise = $offre->getEntrepriseid();

    if (!$userEntreprise) {
        throw $this->createNotFoundException('UserEntreprise not found for the offer');
    }

    // Assuming getLocalisation() returns the Google Maps URL as a string
    $data = $userEntreprise->getLocalisation();
    $qrCode = $qrcodeService->generateQrCodeForLocation($data);

    // Create a PDF with the offer details and QR code
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);
    $html = $this->renderView('offre/pdf_template.html.twig', [
        'offre' => $offre,
        'qrCode' => $qrCode,
    ]);

    $dompdf->loadHtml($html);

    // (Optional) Set the size and orientation of the PDF
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    // Set up the response with the PDF content
    $response = new Response($dompdf->output());
    $response->headers->set('Content-Type', 'application/pdf');

    // Set the file name for download
    $disposition = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'offre_' . $offre->getId() . '.pdf'
    );
    $response->headers->set('Content-Disposition', $disposition);

    return $response;
}









}
