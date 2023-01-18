<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/connexion_defaut', name: 'app_default_login')]
    public function defaultLog(): Response
    {
        /**
         * @var \App\Entity\User
         */
        $user = $this->getUser();

        if (in_array('ROLE_CANDIDATE', $user->getRoles())) {
            return $this->redirectToRoute('app_candidate_show');
        } else {
            return $this->redirectToRoute('app_home');
        }
    }
}
