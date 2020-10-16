<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Form\SuiviType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuiviController extends AbstractController
{
    /**
     * @Route("/suivi", name="suivi")
     */
    public function index()
    {
        return $this->render('suivi/index.html.twig', [
            'controller_name' => 'SuiviController',
        ]);
    }



     /**
     * @Route("/suivi/create", name="suivi_create")
     */
    public function createsuivi(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $suivi = new Suivi();

        $form = $this->createForm(SuiviType::class, $suivi);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $suivi = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $suivi->setDateprise(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($suivi);
            $manager->flush();
            return $this->render('suivi/index.html.twig', [
                'controller_name' => 'suiviController'
            ]);
        }
        return $this->render('suivi/create_suivi.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
