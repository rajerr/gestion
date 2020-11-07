<?php

namespace App\Controller;

use App\Entity\Analyse;
use App\Form\AnalyseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnalyseController extends AbstractController
{
    /**
     * @Route("/analyse", name="analyse_index")
     */
    public function index()
    {
        return $this->render('analyse/index.html.twig', [
            'controller_name' => 'AnalyseController',
        ]);
    }


     /**
     * @Route("/analyse/create", name="analyse_create")
     */
    public function createanalyse(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $analyse = new Analyse();

        $form = $this->createForm(AnalyseType::class, $analyse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $analyse = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $analyse->setDate(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($analyse);
            $manager->flush();
            return $this->render('succes.html.twig');
            return $this->render('analyse/index.html.twig', [
                'controller_name' => 'analyseController'
            ]);
        }
        return $this->render('analyse/create_analyse.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
