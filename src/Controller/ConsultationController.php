<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConsultationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultationController extends AbstractController
{
    /**
     * @Route("/consultation/index", name="consultation_index")
     */
    public function getConsultation(PatientRepository $patientrepos, ConsultationRepository $consultationrepos)
    {
        //$consultation = $consultationrepos->findBy(["patient"=>$id]);
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }



     /**
     * @Route("/consultation/create", name="consultation_create")
     */
    public function createConsultation(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $consultation = new Consultation();

        $form = $this->createForm(ConsultationType::class, $consultation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $consultation = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $consultation -> setMedecin($user);
            $consultation->setDate(new \DateTime('now'));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($consultation);
            $manager->flush();
            return $this->render('consultation/index.html.twig', [
                'controller_name' => 'ConsultationController'
            ]);
        }
        return $this->render('consultation/create_consultation.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
