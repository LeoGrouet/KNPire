<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // $acces = $this->denyAccessUnlessGranted("ROLE_USER");
        // if ($this->$acces = false) {
        //     $this->redirectToRoute("/signin");
        // }

        return $this->render('index.html.twig');
    }
}
