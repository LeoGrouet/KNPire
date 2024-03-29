<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private Security $security,
    ) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $this->getUser();

        return $this->render('index.html.twig', []);
    }
}
