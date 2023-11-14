<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/book/delete/{id}', name: 'admin_deleteoffre')]
    public function deleteBook(Request $request, $id, ManagerRegistry $manager, OffreRepository $offreRepository): Response
    {
        $em = $manager->getManager();
        $book = $offreRepository->find($id);
    
        $em->remove($book);
        $em->flush();
    
        return $this->redirectToRoute('list_offreadmin');
    }
}
