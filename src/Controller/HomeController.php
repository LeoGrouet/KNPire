<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home',  methods: ["GET"])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        return $this->render('index.html.twig', []);
    }
}
