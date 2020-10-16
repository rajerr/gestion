<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/Admin", name="admin")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


     /**
     * @Route("/SousAdmin", name="sousadmin")
     */
    public function indexadmin()
    {
        return $this->render('accueil/indexadmin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/Medecin", name="medecin")
     */
    public function indexmedecin()
    {
        return $this->render('accueil/indexmedecin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/Patient", name="patient")
     */
    public function indexpatient()
    {
        return $this->render('accueil/indexpatient.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/login", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
