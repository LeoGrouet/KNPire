<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserLogType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class LoginController extends AbstractController
{

    #[Route('/login', name: 'app_login')]
    public function loginForm(AuthenticationUtils $authenticationUtils, Request $request, UserRepository $repo, UserPasswordHasherInterface $passwordHasher): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(UserLogType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $person = $repo->findUserByEmail($data["email"])[0];
            $hashedpassword = $passwordHasher->isPasswordValid($person, $data["password"]);
            if ($hashedpassword == $person->getPassword()) {
                return $this->redirectToRoute("home");
            } else {
                $this->addFlash("Failure", "Raté");
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('log/login.html.twig', [
            'form' => $form,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
