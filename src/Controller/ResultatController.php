<?php

namespace App\Controller;

use App\Entity\Resultat;
use App\Form\ResultatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResultatController extends AbstractController
{
    /**
     * @Route("/resultat", name="resultat_index")
     */
    public function index()
    {
        return $this->render('resultat/index.html.twig', [
            'controller_name' => 'ResultatController',
        ]);
    }



     /**
     * @Route("/resultat/create", name="resultat_create")
     */
    public function createresultat(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $resultat = new Resultat();

        $form = $this->createForm(ResultatType::class, $resultat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $resultat = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $resultat->setDate(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($resultat);
            $manager->flush();
            return $this->render('resultat/index.html.twig', [
                'controller_name' => 'resultatController'
            ]);
        }
        return $this->render('resultat/create_resultat.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
