<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\Candidature;
use App\Form\InterviewForm;
use App\Form\InterviewType;
use App\Form\OffreFormType;
use App\Repository\CalendaractivityRepository;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CalendarType;
use Psr\Log\LoggerInterface;

use App\Repository\CandidatureRepository;
use Symfony\Component\Notifier\Event\NotificationEvents;
use Symfony\Component\Notifier\Notification\PushNotificationInterface;
use Symfony\Component\Routing\Annotation\Route;

class InterviewController extends AbstractController
{
   
#[Route('/showcalender', name: 'show_interiew')]
    public function index(CalendarRepository $calendarRepository): Response
    {
        $events = $calendarRepository->findAll();
    
        $rdvs = [];
    
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'date' => $event->getDate()->format('Y-m-d H:i:s'),
                'heure' => $event->getHeure(),
            ];
        }
    
        $data = json_encode($rdvs);
        return $this->render('interview/calender.html.twig', ['data' => $data]);

    }

    #[Route('/c', name: 'list_interview')]
    public function listBook(CalendarRepository $offrerepository): Response
    {

        return $this->render('interview/show.html.twig', [
            'interview' => $offrerepository->findAll(),
        ]);
    }

    #[Route('/interview/edit/{id}', name: 'edit_interview', methods: ['GET', 'POST'])]
    public function editOffre(Request $request, ManagerRegistry $manager, $id, CalendarRepository $calendarRepository): Response
{
    $em = $manager->getManager();

    $calendar = $calendarRepository->find($id);

    if (!$calendar) {
        throw $this->createNotFoundException('interview not found');
    }

    $form = $this->createForm(CalendarType::class, $calendar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($calendar);
        $em->flush();

        return $this->redirectToRoute('list_interview');
    }

    return $this->render('interview/edit.html.twig', [
        'calendar' => $calendar,
        'form' => $form,
    ]);
} 


/* public function edit(Request $request, Calendar $calendar, CalendarRepository $calendarRepository): Response
{
    $form = $this->createForm(CalendarType::class, $calendar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $calendarRepository->save($calendar);

        $this->addFlash('success', 'Calendar updated successfully.');
        return $this->redirectToRoute('list_interview');
    }

    return $this->render('interview/edit.html.twig', [
        'calendar' => $calendar,
        'form' => $form->createView(),
    ]);
} */


    
    
    #[Route('/addevent', name: 'add_interiew')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
{
        $candidature = $entityManager->getRepository(Candidature::class)->find(1);

        
     $calendar = new Calendar();
        $calendar->setCondidature($candidature);

        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission
            $entityManager->persist($calendar);
            $entityManager->flush();
    
            return $this->redirectToRoute('list_interview'); // Replace with the actual route name
        }
    
        return $this->render('interview/addinterview.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/addevent/{candidature}', name: 'add_interie')]
public function new1(Request $request, EntityManagerInterface $entityManager, Candidature $candidature): Response
{
    // No need to fetch $candidature again, it's already injected by Symfony
    
    $calendar = new Calendar();
    $calendar->setCondidature($candidature);

    $form = $this->createForm(CalendarType::class, $calendar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle form submission
        $entityManager->persist($calendar);
        $entityManager->flush();

        // Mark the candidature as treated
        $candidature->setIsTreated(true);
        
        // Persist and flush the candidature to save the changes
        $entityManager->persist($candidature);
        $entityManager->flush();

        return $this->redirectToRoute('list_interview'); // Replace with the actual route name
    }

    return $this->render('interview/addinterview.html.twig', [
        'form' => $form->createView(),
        'candidature' => $candidature,
    ]);
}

    
    
    





    #[Route('/interview/delete/{id}', name: 'interview_delete')]
public function deleteBook(Request $request, $id, ManagerRegistry $manager, CalendarRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('list_interview');
}






}









