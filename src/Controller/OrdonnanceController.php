<?php

namespace App\Controller;

use DateTime;
use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrdonnanceController extends AbstractController
{
    /**
     * @Route("/ordonnance", name="ordonnance_index")
     */
    public function index()
    {
        return $this->render('ordonnance/index.html.twig', [
            'controller_name' => 'OrdonnanceController',
        ]);
    }



     /**
     * @Route("/ordonnance/create", name="ordonnance_create")
     */
    public function createOrdonnance(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $ordonnance = new Ordonnance();

        $form = $this->createForm(OrdonnanceType::class, $ordonnance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $ordonnance = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $ordonnance->setDate(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ordonnance);
            $manager->flush();
            return $this->render('succes.html.twig');
            return $this->render('ordonnance/index.html.twig', [
                'controller_name' => 'ordonnanceController'
            ]);
        }
        return $this->render('ordonnance/create_ordonnance.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
