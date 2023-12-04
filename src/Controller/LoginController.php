<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UseretudiantRepository;
use App\Repository\UserentrepriseRepository;
use App\Repository\UserAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    private $userRepository;
    private $entityManager;
    private $userEtreRepositor;
    private $userAdmin;

     public function __construct(UseretudiantRepository $userRepository, UserentrepriseRepository $userEtreRepositor,UserAdminRepository $userAdmin  , EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userEtreRepositor = $userEtreRepositor;
        $this->userAdmin = $userAdmin;
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, SessionInterface $session): Response
    {
        $error = null;
    
        if ($request->isMethod('POST')) {
            $email = $request->request->get('_email');
            $password = $request->request->get('_password');

            $user = $this->userRepository->findOneBy([
                'email' => $email,
                'motDePasse' => $password,
            ]);
            $user1 = $this->userEtreRepositor->findOneBy([
                'email' => $email,
                'motDePasse' => $password,
            ]);
            $user2 = $this->userAdmin->findOneBy([
                'email' => $email,
                'motDePasse' => $password,
            ]);

            if ($user && $user->getRole() === 'ETUDIANT') {
                // Enregistrez l'utilisateur dans la session après la connexion
                $session->set('user', $user);
                return $this->redirectToRoute('app_home_etudiant');
            } elseif ($user1 && $user1->getRole() === 'ENTREPRISE') {
                // Enregistrez l'utilisateur dans la session après la connexion
                $session->set('user', $user1);
                return $this->redirectToRoute('app_home_entreprise');
            } elseif ($user2 && $user2->getRole() === 'ADMIN') {
                // Enregistrez l'utilisateur dans la session après la connexion
                $session->set('user', $user2);
                return $this->redirectToRoute('stats_admin');
            } 
            
            
            
            else {
                $error = 'Invalid credentials'; // Gérer les erreurs d'authentification
            }
        }
    
        return $this->render('login/login.html.twig', [
            'error' => $error,
        ]);
    }
    

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // La méthode de déconnexion peut être vide car elle ne sera jamais exécutée
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
