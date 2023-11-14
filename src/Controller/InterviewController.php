<?php

namespace App\Controller;

use App\Entity\Calendaractivity;
use App\Form\InterviewForm;
use App\Form\InterviewType;
use App\Form\OffreFormType;
use App\Repository\CalendaractivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterviewController extends AbstractController
{
   
#[Route('/showcalender', name: 'show_interiew')]
    public function index(CalendaractivityRepository $calendarRepository): Response
    {
        $events = $calendarRepository->findAll();
    
        $rdvs = [];
    
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'date' => $event->getDate()->format('Y-m-d H:i:s'),
                'heure' => $event->getHeure(),
                'etudiant_id' => $event->getEtudiantId(),
            ];
        }
    
        $data = json_encode($rdvs);
        return $this->render('interview/calender.html.twig', ['data' => $data]);

    }

    #[Route('/listInterview', name: 'list_interview')]
    public function listBook(CalendaractivityRepository $offrerepository): Response
    {

        return $this->render('interview/show.html.twig', [
            'interview' => $offrerepository->findAll(),
        ]);
    }

    #[Route('/interview/edit/{id}', name: 'edit_interview')]
public function editOffre(Request $request, ManagerRegistry $manager, $id, CalendaractivityRepository $calendarRepository): Response
{
    $em = $manager->getManager();

    $interview = $calendarRepository->find($id);

    if (!$interview) {
        throw $this->createNotFoundException('interview not found');
    }

    $form = $this->createForm(InterviewType::class, $interview);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($interview);
        $em->flush();

        return $this->redirectToRoute('list_interview');
    }

    return $this->renderForm('interview/edit.html.twig', [
        'interview' => $interview,
        'form' => $form,
    ]);
}

    
    
    #[Route('/addinterview', name: 'add_interiew')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $calendar = new Calendaractivity();
        $form = $this->createForm(InterviewType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('list_interview'); // Replace 'your_route' with the actual route name
        }

        return $this->render('interview/addinterview.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/interview/delete/{id}', name: 'interview_delete')]
public function deleteBook(Request $request, $id, ManagerRegistry $manager, CalendaractivityRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('list_interview');
}

   }



