<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="name_accueil")
     */
    public function index()
    {
        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/menu", name="name_menu")
     */
    public function menu()
    {
        return $this->render('menu.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


}
