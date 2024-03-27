<?php

namespace App\Controller;

// ...

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function index(UserPasswordHasherInterface $passwordHasher) // Response
    {
        // ... e.g. get the user data from a registration form
        $user = new User();
        // TODO : Give password data to this variable 
        $plaintextPassword = " ";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        // ...
    }

    #[Route('/signin', name: 'app_signin')]
    public function signin(Request $request, EntityManagerInterface $em): Response
    {

        // J'instancie un nouveau formulaire via RecipeType qui remplira ma recette 
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Je crée un nouveau user vide
            $data = $form->getData();
            $user = new User();
            $user->setEmail($data["Email"]);
            $user->setUsername($data["Username"]);
            $user->setPassword($data["Password"]);
            $em->persist($user);
            $em->flush();
            $this->addFlash('Succes', 'Nouveau User crée');
            return $this->redirectToRoute('home');
        }
        return $this->render('log/signin.html.twig', [
            'form' => $form
        ]);
        return $this->render('log/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
