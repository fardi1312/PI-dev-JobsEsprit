<?php

namespace App\Controller;

use App\Form\MailType;
use App\Repository\CandidatureRepository;
use App\Repository\UseretudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;



class MailerController extends AbstractController
{
    
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer, CandidatureRepository $condidatureRepo, Request $request)
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the submitted email from the form
            $submittedEmail = $form->get('mail')->getData();
    
            // Find the condidature by the submitted email
            $condidature = $condidatureRepo->findOneBy(['etudiant' => ['mail' => $submittedEmail]]);
    
            // Check if the condidature's etudiant is treated and has a valid email
            if ($condidature && $condidature->getEtudiant() && $condidature->isIsTreated() && $condidature->getEtudiant()->getEmail()) {
                // Create and send the email
                $email = (new Email())
                    ->from('benothmen.ons@esprit.tn')
                    ->to($condidature->getEtudiant()->getEmail())
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->html('<p>See Twig integration for better HTML integration!</p>');
    
                $mailer->send($email);
    
            } else {
                $this->addFlash('warning', 'Condidature or etudiant not found or not treated.');
            }
        }
    
        return $this->render("mailer/index.html.twig", ['form' => $form->createView()]);
    }
    

    }
    

