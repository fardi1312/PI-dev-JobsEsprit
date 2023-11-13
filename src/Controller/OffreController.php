<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OffreFormType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class OffreController extends AbstractController
{
   #[Route('/test', name: 'app_show')]
    public function add(): Response
    {
        return $this->render('calender.html.twig', [
            'controller_name' => 'HomeEntrepriseController',
        ]);
    }
   

    #[Route('/listoffre', name: 'list_offre')]
    public function listBook(OffreRepository $offrerepository): Response
    {

        return $this->render('offre/show.html.twig', [
            'offres' => $offrerepository->findAll(),
        ]);
    }

    #[Route('/home/etudiant', name: 'app_home_etudiant')]

    public function index(OffreRepository $offreRepository): Response
    {
        // Utilisez la méthode du repository pour récupérer les trois offres les plus récentes
        $offres = $offreRepository->findNewestThree();

        return $this->render('baseEtudiant.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/form', name: 'app_form')]
public function showForm(Request $request, EntityManagerInterface $entityManager): Response
{
    $offre = new Offre(); // Create a new Offre object
    $form = $this->createForm(OffreFormType::class, $offre); // Create the form using the form type
    $form->handleRequest($request); // Handle the form submission

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle form submission, for example, persist the entity to the database
        $entityManager->persist($offre);
        $entityManager->flush();

        // Redirect to the appropriate route after successful form submission
        return $this->redirectToRoute('list_offre'); // Replace 'your_success_route_name' with the actual route name
    }

    return $this->render('offre/form.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/offre/edit/{id}', name: 'edit_offre')]
public function editOffre(Request $request, ManagerRegistry $manager, $id, OffreRepository $offreRepository): Response
{
    $em = $manager->getManager();

    $offre = $offreRepository->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('Offre not found');
    }

    $form = $this->createForm(OffreFormType::class, $offre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($offre);
        $em->flush();

        return $this->redirectToRoute('list_offre');
    }

    return $this->renderForm('offre/editBook.html.twig', [
        'offre' => $offre,
        'form' => $form,
    ]);
}
#[Route('/book/delete/{id}', name: 'book_delete')]
public function deleteBook(Request $request, $id, ManagerRegistry $manager, OffreRepository $offreRepository): Response
{
    $em = $manager->getManager();
    $book = $offreRepository->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('list_offre');
}

#[Route('/book/details/{id}', name: 'offre_details')]
public function show(OffreRepository $offreRepository, $id): Response
{
    return $this->render('offre/showDetails.html.twig', [
        'offre' => $offreRepository->find($id),
    ]);
}



}
