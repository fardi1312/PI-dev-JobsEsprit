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
use App\Entity\Userentreprise;

use App\Repository\CandidatureRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Event\NotificationEvents;
use Symfony\Component\Notifier\Notification\PushNotificationInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InterviewController extends AbstractController
{
    private $mailer;
    
    

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
       
    }
#[Route('/showcalender', name: 'show_interiew')]
    public function index(CalendarRepository $calendarRepository, SessionInterface $session): Response
    {
        $user = $session->get('user');
    
        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

       
        $events = $calendarRepository->findBy(['entreprise' => $user->getId()]);

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

   

    #[Route('/listevent', name: 'list_interview')]
    public function listBook(CalendarRepository $calendar, SessionInterface $session): Response
    {
        // Récupérer l'utilisateur depuis la session
        $user = $session->get('user');
    
        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }
    
        // Récupérer la liste des offres associées à l'entreprise de l'utilisateur
        $filteredOffres = $calendar->findBy(['entreprise' => $user->getId()]);
    
        return $this->render('interview/show.html.twig', [
            'interview' => $filteredOffres,
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
        $this->sendEmail($calendar);

        return $this->redirectToRoute('list_interview', ['message' => 'Interview updated successfully'], Response::HTTP_SEE_OTHER);
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
    
            return $this->redirectToRoute('list_interview', ['message' => 'Interview Added successfully'], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('interview/addinterview.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/addevent/{candidature}', name: 'add_interie')]
public function new1(Request $request, EntityManagerInterface $entityManager, Candidature $candidature,SessionInterface $session): Response
{
    // No need to fetch $candidature again, it's already injected by Symfony
   


    $user = $session->get('user');
    if (!$user) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        return $this->redirectToRoute('app_login');
    }
    // Assuming Entreprise is associated with Offre, adjust this based on your entity relationships
    $entreprise = $entityManager->getRepository(Userentreprise::class)->find($user->getId());
    
    $calendar = new Calendar();
    $calendar->setCondidature($candidature);
    $calendar->setEntreprise($entreprise);

    $form = $this->createForm(CalendarType::class, $calendar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle form submission
        $entityManager->persist($calendar);
        $entityManager->flush();
        $this->sendEmail($calendar);

        // Mark the candidature as treated
        $candidature->setIsTreated(true);
        
        // Persist and flush the candidature to save the changes
        $entityManager->persist($candidature);
        $entityManager->flush();

        return $this->redirectToRoute('list_interview', ['message' => 'Interview Added successfully'], Response::HTTP_SEE_OTHER);
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

    return $this->redirectToRoute('list_interview', ['message' => 'Interview Deleted successfully'], Response::HTTP_SEE_OTHER);
}


private function sendEmail(Calendar $calendar): void
{
    // Accédez aux entités liées pour obtenir l'adresse e-mail
    $etudiantEmail = $calendar->getCondidature()->getEtudiant()->getEmail();

    // Vérifiez si l'adresse e-mail est définie
    if ($etudiantEmail) {
        // Créez les données à passer au template Twig
        $emailData = [
            'calendar' => $calendar,
            // Ajoutez d'autres données que vous souhaitez passer au modèle ici
        ];

        // Créez le corps HTML de l'e-mail
        $emailBody = $this->renderView('interview/mail.html.twig', $emailData);

        // Créez l'e-mail avec le corps HTML
        $email = (new Email())
            ->from('test.pidev123@gmail.com')
            ->to($etudiantEmail)
            ->subject('Confirmation d\'entretien')
            ->html($emailBody);

        $this->mailer->send($email);
    }
}





}