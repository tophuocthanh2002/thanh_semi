<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class LoginController extends AbstractController
{


    #[Route('/login', name: 'app_login', methods: ["GET", "POST"])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // If the user is already logged in, redirect to the index page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(LogoutSuccessHandlerInterface $logoutSuccessHandler): RedirectResponse
    {
        return $logoutSuccessHandler->onLogoutSuccess($this->get('request_stack')->getCurrentRequest());
    }
}
