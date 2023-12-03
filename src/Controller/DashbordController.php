<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Calendaractivity;
use App\Repository\CalendaractivityRepository;
use App\Repository\CalendarRepository;
use App\Repository\OffreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashbordController extends AbstractController
{
    #[Route('/admin', name: 'app_dashbord')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashbordController',
        ]);
    }
    #[Route('/findadmin', name: 'list_offreadmin')]
    public function listBook(OffreRepository $offrerepository): Response
    {

        return $this->render('dashboard/offres.html.twig', [
            'offres' => $offrerepository->findAll(),
        ]);
    }
    #[Route('/adminevents', name: 'events_admin')]
    public function listEvent(CalendarRepository $offrerepository): Response
    {

        return $this->render('dashboard/interview.html.twig', [
            'calendaractivities' => $offrerepository->findAll(),
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
    


    #[Route('/stats', name: 'stats_admin')]
    public function stats(OffreRepository $offreRepository): Response
    {
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
    
        return $this->render('dashboard/test.html.twig', [
            'percentages' => $percentages,
            'monthlyCounts1' => $monthlyCounts1,

        ]);
    }


   public function offerStats(OffreRepository $offreRepository): Response
   {
       $monthlyCounts = $offreRepository->getMonthlyOfferCounts();

       return $this->render('dashboard/test.html.twig', [
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
