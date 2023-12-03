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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/covoiturage')]
class CovoiturageController extends AbstractController
{



    #[Route('/home/etudiant1', name: 'app_home_etudiant1')]
    public function index( CovoiturageRepository  $covoiturageRepository       , SessionInterface $session): Response
    {
        // Récupérer les données de l'utilisateur depuis la session
        $covoiturage = $covoiturageRepository->findNewestThree();
        $user = $session->get('user');
        return $this->render('baseEtudiant.html.twig', [
            'user' => $user,
            'user' => $user,
            'covoiturage' => $covoiturage,
        ]);
    }











    #[Route('/list', name: 'app_covoiturage_index', methods: ['GET'])]
    public function index1(CovoiturageRepository $covoiturageRepository, SessionInterface $session): Response
    {
        $user = $session->get('user');
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $covoiturages = $covoiturageRepository->findAll();
        $filteredCovoiturages = array_filter($covoiturages, function ($covoiturage) use ($user) {
            return $covoiturage->getUsername() === $user->getUsername();
        });
        return $this->render('covoiturage/show.html.twig', [
            'covoiturage' => $filteredCovoiturages,
        ]);
    }
   
    #[Route('/post', name: 'app_covoiturage_post', methods: ['GET'])]
    public function post(CovoiturageRepository $covoiturageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Use the findAll method to get all records
        $query = $covoiturageRepository->findAll();
    
        $pagination = $paginator->paginate(
            $query, // Doctrine QueryBuilder (not result)
            $request->query->getInt('page', 1), // Current page number
            3// Number of items per page
        );
    
        return $this->render('covoiturage/showpost.html.twig', [
            'pagination' => $pagination,
            'covoiturage' => $query,
        ]);
    }
    


    #[Route('/new', name: 'app_covoiturage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CovoiturageRepository $covoiturageRepository, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $covoiturage = new Covoiturage();
        $user = $session->get('user');
        $covoiturage->setUsername($user->getUsername());
        $form = $this->createForm(CovoiturageType::class, $covoiturage);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['image']->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), 
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception
                }
    
                $covoiturage->setImage($newFilename);
            }
////////////////////////////////////////////////////////////
    $notificationText = sprintf(
        'New Covoiturage Added by %s from %s to %s',
        $covoiturage->getUsername(),
        $covoiturage->getLieuDepart(),
        $covoiturage->getLieuArrivee()
    );
            $notification = new Notification();
            $notification->setText($notificationText);
            $notification->setCreatedAt(new \DateTime());
    
            $entityManager->persist($notification);
            $entityManager->flush();
 ///////////////////////////////////////////////////////////////////   
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
    public function edit(Request $request, Covoiturage $covoiturage, CovoiturageRepository $covoiturageRepository, EntityManagerInterface $entityManager): Response
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
                        $this->getParameter('images_directory'), 
                        $newFilename
                    );
                    $covoiturage->setImage($newFilename);
                } catch (FileException $e) {
                    // Handle the exception
                }
            } 
    
            // Personalized notification text for edit action
            $notificationText = sprintf(
                'Covoiturage edited by %s from %s to %s',
                $covoiturage->getUsername(),
                $covoiturage->getLieuDepart(),
                $covoiturage->getLieuArrivee()
            );
    
            $notification = new Notification();
            $notification->setText($notificationText);
            $notification->setCreatedAt(new \DateTime());
    
            $entityManager->persist($notification);
            $entityManager->flush();
    
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
