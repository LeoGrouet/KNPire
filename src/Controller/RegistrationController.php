<?php

namespace App\Controller;

// ...

use App\Entity\User;
use App\Form\UserSignInType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function signin(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserSignInType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = new User(
                $data["username"],
                $data["email"],
                $plaintextPassword = $data["password"]
            );
            $em->persist($user);

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $em->flush();
            $this->addFlash('Succes', 'Nouveau User créé');
            return $this->redirectToRoute('home');
        }
        return $this->render('log/signin.html.twig', [
            'form' => $form
        ]);
    }
}
