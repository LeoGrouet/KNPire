<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Attribute\Route;


class UserController extends AbstractController
{
    public function __construct(public Security $security)
    {
    }

    #[Route('/profil', name: "app_profil")]
    public function index()
    {

        $user = $this->security->getUser();

        return $this->render('user/profiluser.html.twig', [
            'user' => $user
        ]);
    }
}
