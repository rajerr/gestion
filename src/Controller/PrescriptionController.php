<?php

namespace App\Controller;

use DateTime;
use App\Entity\Prescription;
use App\Form\PrescriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrescriptionController extends AbstractController
{
    /**
     * @Route("/prescription/index", name="prescription_index")
     */
    public function index()
    {
        return $this->render('prescription/index.html.twig', [
            'controller_name' => 'PrescriptionController',
        ]);
    }


        /**
     * @Route("/prescription/index", name="prescription_patient")
     */
    public function getPrescriptionPatient()
    {
        return $this->render('prescription/index.html.twig', [
            'controller_name' => 'PrescriptionController',
        ]);
    }



     /**
     * @Route("/prescription/create", name="prescription_create")
     */
    public function createPrescription(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $prescription = new Prescription();

        $form = $this->createForm(PrescriptionType::class, $prescription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $prescription = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $prescription->setDate(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($prescription);
            $manager->flush();
            return $this->render('succes.html.twig');
            return $this->render('prescription/index.html.twig', [
                'controller_name' => 'prescriptionController'
            ]);
        }
        return $this->render('prescription/prescription_create.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
