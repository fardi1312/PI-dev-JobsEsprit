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
use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Calendaractivity;
use App\Repository\CalendaractivityRepository;
use App\Repository\CalendarRepository;
use App\Repository\OffreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/dashbord')]

class DashbordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
    



/////////////////////////////////




#[Route('/findadmin', name: 'list_offreadmin')]
public function listBook(OffreRepository $offrerepository , NotificationRepository $notificationRepository): Response
{

    return $this->render('dashbord/offres.html.twig', [
        'offres' => $offrerepository->findAll(),
        ///////////MASSOUD//////////
        'notifications' =>  $notificationRepository->findRecentNotifications(100),
        //////////////////////////
    ]);
}
#[Route('/adminevents', name: 'events_admin')]
public function listEvent(CalendarRepository $offrerepository, NotificationRepository $notificationRepository ): Response
{

    return $this->render('dashbord/interview.html.twig', [
        'calendaractivities' => $offrerepository->findAll(),
        ///////////MASSOUD//////////
        'notifications' =>  $notificationRepository->findRecentNotifications(100),
        //////////////////////////

    ]);
}
#[Route('/book/delete/{id}', name: 'admin_deleteoffre')]
public function deleteBook(Request $request, $id, ManagerRegistry $manager, OffreRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('list_offreadmin');
}
#[Route('/event/delete/{id}', name: 'admin_deleteeevnt')]
public function deleteEvent(Request $request, $id, ManagerRegistry $manager, CalendarRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('events_admin');
}





#[Route('/', name: 'stats_admin')]
public function stats(OffreRepository $offreRepository, NotificationRepository $notificationRepository ,  CovoiturageRepository $covoiturageRepository, ConfirmCovoiturageRepository $confirmCovoiturageRepository): Response
{






        ////////////////////////////////////////////////
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
        //////////////////////////////









    $monthlyCounts = $offreRepository->getPercentageByCompanyPerMonth();
    $monthlyCounts1 = $offreRepository->getMonthlyOfferCounts();

    // Calculate total activity for each month and year
    $totalActivity = [];
    foreach ($monthlyCounts as $companyName => $monthlyCount) {
        foreach ($monthlyCount as $year => $counts) {
            foreach ($counts as $month => $count) {
                // Initialize total activity for the month and year
                if (!isset($totalActivity[$year][$month])) {
                    $totalActivity[$year][$month] = 0;
                }

                // Accumulate the activity for the month and year
                $totalActivity[$year][$month] += $count;
            }
        }
    }

    // Calculate percentages for each company
    $percentages = [];
    foreach ($monthlyCounts as $companyName => $monthlyCount) {
        foreach ($monthlyCount as $year => $counts) {
            foreach ($counts as $month => $count) {
                // Calculate the percentage based on the total activity for the month and year
                $percentage = $totalActivity[$year][$month] > 0 ? ($count / $totalActivity[$year][$month]) * 100 : 0;

                // Initialize the percentages array for the company and year
                if (!isset($percentages[$companyName][$year])) {
                    $percentages[$companyName][$year] = [];
                }

                // Set the calculated percentage
                $percentages[$companyName][$year][$month] = $percentage;
            }
        }
    }

    return $this->render('dashbord/test.html.twig', [
        'percentages' => $percentages,
        'monthlyCounts1' => $monthlyCounts1,
        ///////////MASSOUD////////////////////////////////////////
        'notifications' =>  $notificationRepository->findRecentNotifications(100),
        'confirmedCount' => $confirmedCount,
        'unconfirmedCount' => $unconfirmedCount,
        'citySuggestionsArrival' => $citySuggestionsArrival,
        'citySuggestionsDeparture' => $citySuggestionsDeparture,
        //////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////


    ]);
}


public function offerStats(OffreRepository $offreRepository): Response
{
   $monthlyCounts = $offreRepository->getMonthlyOfferCounts();

   return $this->render('dashbord/test.html.twig', [
       'monthlyCounts' => $monthlyCounts,
   ]);
}



#[Route("/change_locale/{locale}", name: "change_locale")]
public function changeLocale($locale, Request $request)
{
   // Check if the selected locale is valid in your application
   $validLocales = ['en', 'fr']; // Add other supported locales

   if (!in_array($locale, $validLocales)) {
       // Handle invalid locale, redirect to a default or previous page
       return $this->redirectToRoute('default_route');
   }

   // Set the locale using setlocale
   setlocale(LC_ALL, $locale . '_' . strtoupper($locale));

   // Create a Symfony\HttpFoundation\Cookie object to store the selected locale
   $cookie = new \Symfony\Component\HttpFoundation\Cookie('_locale', $locale, time() + (365 * 24 * 60 * 60));

   // Create a response with the cookie
   $response = new RedirectResponse($request->headers->get('referer'));
   $response->headers->setCookie($cookie);

   return $response;
}










}
