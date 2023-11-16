<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/details', name: 'user_details')]
    public function userDetails(): Response
    {
        return $this->render('detail.html.twig');
    }
}
