<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSignInType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/signin', name: 'app_signin',  methods: ["POST", "GET"])]
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
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Nouveau User créé');
            return $this->redirectToRoute('home');
        }
        return $this->render('log/signin.html.twig', [
            'form' => $form
        ]);
    }
}
