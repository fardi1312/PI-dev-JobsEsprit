<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    private $userRepository;
    private $entityManager;

    public function __construct(UserEtudiantRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
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

            if ($user) {
                // Enregistrez l'utilisateur dans la session après la connexion
                $session->set('user', $user);

                if ($user->getRole() === 'ETUDIANT') {
                    return $this->redirectToRoute('app_home_etudiant');
                } elseif ($user->getRole() === 'ENTREPRISE') {
                    return $this->redirectToRoute('app_home_entreprise');
                }
            } else {
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
