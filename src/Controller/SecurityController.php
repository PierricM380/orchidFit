<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * This controller allow us to login
 *
 * @param AuthenticationUtils $authenticationUtils
 * @return Response
 */
class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()

        ]);
    }

    /**
     * This controller allow us to logout
     *
     * @return void
     */
    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        // Noting to do here...
    }
}
