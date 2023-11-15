<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Portfolio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    #[Route('/addPortfolio', name: 'app_form')]
    public function showForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portfolio = new Portfolio(); // Create a new portfolio object
        $form = $this->createForm(PortfolioType::class, $portfolio); // Create the form using the form type
        $form->handleRequest($request); // Handle the form submission
    
        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('image')->getData();
    
            if ($uploadedFile) {
                $imageDirectory = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid().'.'.$uploadedFile->guessExtension();
    
                try {
                    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                    $uploadedFile->move($destination, $newFilename);
                } catch (FileException $e) {
                    // Handle the file upload exception
                }
    
                $portfolio->setImage('uploads/'.$newFilename);
            }
            // Handle form submission, for example, persist the entity to the database
            $entityManager->persist($portfolio);
            $entityManager->flush();
    
            return $this->redirectToRoute('list_portfolio');   // Redirect to the appropriate route after successful form submission
        }
       // Replace 'your_success_route_name' with the actual route name
    
        return $this->render('portfolio/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


#[Route('/listportfolio', name: 'list_portfolio')]
public function listPortfolio(PortfolioRepository $Portfoliorepository): Response
{

    return $this->render('portfolio/show.html.twig', [
        'portfolios' => $Portfoliorepository->findAll(),
    ]);
}


#[Route('/portfolio/edit/{id}', name: 'edit_portfolio')]
public function editPortfolio(Request $request, EntityManagerInterface $entityManager, $id, PortfolioRepository $portfolioRepository): Response
{
    $portfolio = $portfolioRepository->find($id);

    if (!$portfolio) {
        throw $this->createNotFoundException('Portfolio not found');
    }

    $form = $this->createForm(PortfolioType::class, $portfolio);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        // Les propriétés du portfolio sont automatiquement mises à jour grâce au formulaire.

        $entityManager->flush();

        return $this->redirectToRoute('list_portfolio');
    }

    return $this->renderForm('portfolio/editPortfolio.html.twig', [
        'portfolio' => $portfolio,
        'form' => $form,
    ]);
}



#[Route('/portfolio/delete/{id}', name: 'portfolio_delete')]
public function deletePortfolio(Request $request, $id, ManagerRegistry $manager, PortfolioRepository $portfolioRepository): Response
{
    $em = $manager->getManager();
    $portfolio = $portfolioRepository->find($id);

    $em->remove($portfolio);
    $em->flush();

    return $this->redirectToRoute('list_portfolio');
}

#[Route('/portfolio/details/{id}', name: 'portfolio_details')]
public function show(PortfolioRepository $portfolioRepository, $id): Response
{
    return $this->render('portfolio/showDetails.html.twig', [
        'portfolio' => $portfolioRepository->find($id),
    ]);
}

}