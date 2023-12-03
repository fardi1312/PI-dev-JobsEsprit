<?php

namespace App\Controller\Dashbord;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConfirmCovoiturageRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\CovoiturageRepository;
use App\Entity\ConfirmCovoiturage;
use App\Entity\Covoiturage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Notification;
use App\Repository\NotificationRepository;


#[Route('/dashbord')]

class DashbordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/', name: 'app_dashbord')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notifications = $notificationRepository->findRecentNotifications(100);

        return $this->render('dashboard.html.twig', [
            'controller_name' => 'DashbordController',
           'notifications' => $notifications,
        ]);


    }

    #[Route('/listAdminConfirmCovoiturage', name: 'app_confirm_covoiturage_indexAdmin', methods: ['GET'])]
    public function indexAdmin(CovoiturageRepository $covoiturageRepository, ConfirmCovoiturageRepository $confirmCovoiturageRepository, SessionInterface $session, NotificationRepository $notificationRepository): Response
    {   
        
        $notifications = $notificationRepository->findRecentNotifications(100);
        $covoiturages = $covoiturageRepository->findAll();
        $confirmCovoiturages = $confirmCovoiturageRepository->findAll(); 
        $citySuggestionsArrival = $confirmCovoiturageRepository->findCitySuggestionsArrivalCount();
        $citySuggestionsDeparture = $confirmCovoiturageRepository->findCitySuggestionsDepartureCount();
        $confirmedCount = 0;
        $unconfirmedCount = 0;
        foreach ($confirmCovoiturages as $confirmCovoiturage) {
            if ($confirmCovoiturage->isConfirmed()) {
                $confirmedCount++;
            } else {
                $unconfirmedCount++;
            }
        }
        return $this->render('dashbord/indexAdmin.html.twig', [
            'covoiturage' => $covoiturages,
            'confirm_covoiturages' => $confirmCovoiturages,
            'confirmedCount' => $confirmedCount,
            'unconfirmedCount' => $unconfirmedCount,
            'citySuggestionsArrival' => $citySuggestionsArrival,
            'citySuggestionsDeparture' => $citySuggestionsDeparture,
            'notifications' => $notifications,


        ]);
    }

    #[Route('confirm/{id}', name: 'app_confirm_covoiturage_deleteAdminConfirm', methods: ['POST'])]
    public function deleteConfirm(Request $request, ConfirmCovoiturage $confirmCovoiturage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$confirmCovoiturage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($confirmCovoiturage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_confirm_covoiturage_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('Covoiturage/{id}', name: 'app_covoiturage_deleteAdminCovoiturage', methods: ['POST'])]
    public function deleteCovoiturage(Request $request, Covoiturage $covoiturage, CovoiturageRepository $covoiturageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $covoiturage->getId(), $request->request->get('_token'))) {
            $covoiturageRepository->remove($covoiturage, true);
            $this->addFlash('success', 'Covoiturage deleted successfully.');
        }

        return $this->redirectToRoute('app_confirm_covoiturage_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }
    


    #[Route('/notification', name: 'app_notification')]
    public function index1(): Response
    {
        $notificationRepository = $this->entityManager->getRepository(Notification::class);
        $recentNotificationCount = $notificationRepository->getRecentNotificationCount(100);
    
        return $this->json(['count' => $recentNotificationCount]);
    }
    











}
