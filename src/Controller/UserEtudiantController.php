<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserEtudiant;
use App\Form\UserEtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request; 



class UserEtudiantController extends AbstractController
{
    #[Route('/user/etudiant', name: 'app_user_etudiant')]
    public function index(): Response
    {
        return $this->render('user_etudiant/index.html.twig', [
            'controller_name' => 'UserEtudiantController',
        ]);
    }



    
    #[Route('/users/{id}', name: 'user_show')]
    public function show($id, UserEtudiantRepository $userEtudiantRepository): Response
    {
        $userEtudiant = $userEtudiantRepository->find($id);

        if (!$userEtudiant) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->render('user_etudiant/show.html.twig', [
            'user' => $userEtudiant,
        ]);
    }
    
   


    #[Route('/useretudiant/create', name: 'useretudiant_create')]
    public function create(Request $request , EntityManagerInterface $entityManager): Response
    {
        $userEtudiant = new UserEtudiant();
        $form = $this->createForm(UserEtudiantType::class, $userEtudiant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($userEtudiant);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_etudiant');
        }

        return $this->render('/user_etudiant/addetudiant.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/useretudiant/edit/{id}', name: 'edit_useretudiant')]
    public function editUserEtudiant(Request $request, $id, UserEtudiantRepository $userEtudiantRepository, ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $userEtudiant = $userEtudiantRepository->find($id);

        if (!$userEtudiant) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserEtudiantType::class, $userEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('list_etudiant');
        }

        return $this->render('user_etudiant/editUserEtudiant.html.twig', [
            'userEtudiant' => $userEtudiant,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/form', name: 'app_form')]
    public function showForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userEtudiant = new UserEtudiant(); // Crée un nouvel objet UserEtudiant
        $form = $this->createForm(UserEtudiantType::class, $userEtudiant); // Crée le formulaire en utilisant le type de formulaire

        $form->handleRequest($request); // Gère la soumission du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            // Gère la soumission du formulaire, par exemple, persiste l'entité dans la base de données
            $entityManager->persist($userEtudiant);
            $entityManager->flush();

            // Redirige vers la route appropriée après une soumission réussie
            return $this->redirectToRoute('list_etudiant'); // Remplacer 'votre_nom_route_succes' par le nom de route réel
        }

        return $this->render('user_etudiant/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    //afficher une liste de tous les etudiants
    #[Route('/listetudiant', name: 'listetudiant')]
    public function listetudiant(UserEtudiantRepository $UserEtudiantrepository): Response
    {

        return $this->render('user_etudiant/dashboard.html.twig', [
            'users' => $UserEtudiantrepository->findAll(),
        ]);
    }
    


    //delete
    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function delete(Request $request, $id, ManagerRegistry $manager, UserEtudiantRepository $UserEtudiantRepository): Response
    {
        $em = $manager->getManager();
        $userEtudiant = $UserEtudiantRepository->find($id);

        if (!$userEtudiant) {
            throw $this->createNotFoundException('User not found');
        }

        $em->remove($userEtudiant);
        $em->flush();

        return $this->redirectToRoute('listetudiant');
    }

}
