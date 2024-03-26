<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        $test = "coucou";
        return $this->render(
            'index.html.twig',
            [
                'test' => $test
            ]
        );
    }
}
