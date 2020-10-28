<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient_index")
     */
    public function index(PatientRepository $patientrepos)
    {
        $patient = $patientrepos->findAll();
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

     /**
     * @Route("/patient/create", name="patient_create")
     */
    public function create(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $patient = new Patient();

        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();
            dd($patient);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($patient);
            $manager->flush();

            return $this->render('patient/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $patient->getUsername()
            ]);
        }
        return $this->render('patient/create.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

}
