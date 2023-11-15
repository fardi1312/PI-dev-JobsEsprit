<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserEntreprise;
use App\Form\UserEntrepriseType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserEntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request; 

class UserEntrepriseController extends AbstractController
{
    #[Route('/user/entreprise', name: 'app_user_entreprise')]
    public function index(): Response
    {
        return $this->render('user_entreprise/index.html.twig', [
            'controller_name' => 'UserEntrepriseController',
        ]);
    }

    #[Route('/entreprises/{id}', name: 'entreprise_show')]
    public function show($id, UserEntrepriseRepository $userEntrepriseRepository): Response
    {
        $userEntreprise = $userEntrepriseRepository->find($id);

        if (!$userEntreprise) {
            throw $this->createNotFoundException('Entreprise not found');
        }

        return $this->render('user_entreprise/show.html.twig', [
            'entreprise' => $userEntreprise,
        ]);
    }

    #[Route('/userentreprise/create', name: 'userentreprise_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userEntreprise = new UserEntreprise();
        $form = $this->createForm(UserEntrepriseType::class, $userEntreprise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($userEntreprise);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_entreprise');
        }

        return $this->render('user_entreprise/addentreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/userentreprise/edit/{id}', name: 'edit_userentreprise')]
    public function editUserEntreprise(Request $request, $id, UserEntrepriseRepository $userEntrepriseRepository, ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $userEntreprise = $userEntrepriseRepository->find($id);

        if (!$userEntreprise) {
            throw $this->createNotFoundException('Entreprise not found');
        }

        $form = $this->createForm(UserEntrepriseType::class, $userEntreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('listentreprise');
        }

        return $this->render('user_entreprise/editentreprise.html.twig', [
            'userEntreprise' => $userEntreprise,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/formentreprise', name: 'app_formentreprise')]
    public function showFormEntreprise(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userEntreprise = new UserEntreprise();
        $form = $this->createForm(UserEntrepriseType::class, $userEntreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userEntreprise);
            $entityManager->flush();

            return $this->redirectToRoute('list_entreprise');
        }

        return $this->render('user_entreprise/formEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/listentreprise', name: 'listentreprise')]
    public function listEntreprise(UserEntrepriseRepository $userEntrepriseRepository): Response
    {
        return $this->render('user_entreprise/dashboard.html.twig', [
            'users' => $userEntrepriseRepository->findAll(),
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'entreprise_delete')]
    public function deleteEntreprise(Request $request, $id, ManagerRegistry $manager, UserEntrepriseRepository $userEntrepriseRepository): Response
    {
        $em = $manager->getManager();
        $userEntreprise = $userEntrepriseRepository->find($id);

        if (!$userEntreprise) {
            throw $this->createNotFoundException('Entreprise not found');
        }

        $em->remove($userEntreprise);
        $em->flush();

        return $this->redirectToRoute('listentreprise');
    }
}
