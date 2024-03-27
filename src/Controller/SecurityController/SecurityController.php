<?php

namespace App\Controller\SecurityController;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

class SecurityController
{

    // public function index(Security $security, User $user): Response
    // {
    //     $form = $this->createForm(UserType::class);
    //     $form->handleRequest($request);
    //     // get the user to be authenticated
    //     $user= ...;

    //     // log the user in on the current firewall
    //     $security->login($user);

    //     // if the firewall has more than one authenticator, you must pass it explicitly
    //     // by using the name of built-in authenticators...
    //     $security->login($user, 'form_login');
    //     // ...or the service id of custom authenticators
    //     $security->login($user, ExampleAuthenticator::class);

    //     // you can also log in on a different firewall...
    //     $security->login($user, 'form_login', 'other_firewall');

    //     // ...and add badges
    //     $security->login($user, 'form_login', 'other_firewall', [(new RememberMeBadge())->enable()]);

    //     // use the redirection logic applied to regular login
    //     $redirectResponse = $security->login($user);
    //     return $redirectResponse;

    // }
}
