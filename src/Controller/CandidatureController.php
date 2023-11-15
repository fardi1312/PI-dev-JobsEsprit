<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CandidatureType;
use App\Repository\CandidaturRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Candidature;



class CandidatureController extends AbstractController
{
    #[Route('/candidature', name: 'app_candidature')]
    public function index(): Response
    {
        return $this->render('candidature/index.html.twig', [
            'controller_name' => 'CandidatureController',
        ]);
    }

    #[Route('/addCandidature', name: 'app_Candidature')]
    public function FormCandid(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature); // Create the form using the form type
        $form->handleRequest($request); // Handle the form submission
    
        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('cv')->getData();
    
            if ($uploadedFile) {
                $cvDirectory = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid().'.'.$uploadedFile->guessExtension();
    
                try {
                    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                    $uploadedFile->move($destination, $newFilename);
                } catch (FileException $e) {
                    // Handle the file upload exception
                }
    
                $candidature->setCv('uploads/'.$newFilename);
            }
            // Handle form submission, for example, persist the entity to the database
            $entityManager->persist($candidature);
            $entityManager->flush();
    
            return $this->redirectToRoute('candid_details');   // Redirect to the appropriate route after successful form submission
        }
       // Replace 'your_success_route_name' with the actual route name
    
        return $this->render('candidature/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/candidature/details/{id}', name: 'candid_details')]
public function show(CandidatureRepository $candidatureRepository, $id): Response
{

    $candidature = $candidatureRepository->find($id);
    if (!$candidature) {
        throw $this->createNotFoundException('Candidature not found');
    }
    
    return $this->render('candidature/showDetails.html.twig', [
        'candidature' => $candidatureRepository
    ]);
}

}


