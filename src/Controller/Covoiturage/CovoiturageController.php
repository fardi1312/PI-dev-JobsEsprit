<?php

namespace App\Controller\Covoiturage;

use App\Entity\Covoiturage;
use App\Entity\UserEtudiant;

use App\Form\CovoiturageType;
use App\Repository\CovoiturageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/covoiturage')]
class CovoiturageController extends AbstractController
{
    #[Route('/list', name: 'app_covoiturage_index', methods: ['GET'])]
    public function index(CovoiturageRepository $covoiturageRepository): Response
    {
        $covoiturage = $covoiturageRepository->findAll();

        return $this->render('covoiturage/show.html.twig', [
            'covoiturage' => $covoiturage,
        ]);
    }
    #[Route('/post', name: 'app_covoiturage_post', methods: ['GET'])]
    public function post(CovoiturageRepository $covoiturageRepository): Response
    {
        $covoiturage = $covoiturageRepository->findAll();

        return $this->render('covoiturage/showpost.html.twig', [
            'covoiturage' => $covoiturage,
        ]);
    }


    #[Route('/new', name: 'app_covoiturage_new', methods: ['GET', 'POST'])]

    public function new(Request $request, CovoiturageRepository $covoiturageRepository): Response
    {
        $covoiturage = new Covoiturage();
        $form = $this->createForm(CovoiturageType::class, $covoiturage);
        $form->handleRequest($request);
    

    // Fetch the currently authenticated user
    $userEtudiant = $this->getUser();

    // Assuming you have a property like $covoiturages in UserEtudiant entity
    $covoiturage->setIdUserEtudiant($userEtudiant);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form['image']->getData();
    
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Replace with your actual parameter name
                        $newFilename
                    );
                } catch (FileException $e) {
                }
    
                $covoiturage->setImage($newFilename);
            }
    
            $covoiturageRepository->save($covoiturage, true);
            $this->addFlash('success', 'Covoiturage created successfully.');
            return $this->redirectToRoute('app_covoiturage_index');
        }
    
        return $this->renderForm('covoiturage/new.html.twig', [
            'covoiturage' => $covoiturage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_covoiturage_show', methods: ['GET'])]
    public function show(Covoiturage $covoiturage): Response
    {
        return $this->render('covoiturage/showbyid.html.twig', [
            'covoiturage' => $covoiturage,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_covoiturage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Covoiturage $covoiturage, CovoiturageRepository $covoiturageRepository): Response
    {
        $form = $this->createForm(CovoiturageType::class, $covoiturage);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form['image']->getData();
    
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Replace with your actual parameter name
                        $newFilename
                    );
                    $covoiturage->setImage($newFilename);
                } catch (FileException $e) {
                    // Handle file upload error, if needed
                }
            } 
            $covoiturageRepository->save($covoiturage, true);
            $this->addFlash('success', 'Covoiturage updated successfully.');
            return $this->redirectToRoute('app_covoiturage_index');
        }
    
        return $this->renderForm('covoiturage/edit.html.twig', [
            'covoiturage' => $covoiturage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_covoiturage_delete', methods: ['POST'])]
    public function delete(Request $request, Covoiturage $covoiturage, CovoiturageRepository $covoiturageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $covoiturage->getId(), $request->request->get('_token'))) {
            $covoiturageRepository->remove($covoiturage, true);

            $this->addFlash('success', 'Covoiturage deleted successfully.');
        }

        return $this->redirectToRoute('app_covoiturage_index');
    }
}
