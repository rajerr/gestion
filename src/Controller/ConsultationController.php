<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\PatientRepository;
use App\Repository\MedecinRepository;
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
     * @Route("/patient/consultation", name="consultation_patient")
     */
    public function getConsultationPatient(PatientRepository $patientrepos, ConsultationRepository $consultationrepos)
    {
        $patient = $patientrepos->findBy(['statut'=>true]);
        //dd($patient);
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $consultations = $consultationrepos->findByPatient($user);
        // dd($consultations);
        foreach($patient as $p){
            foreach($consultations as $c){
                if($user == $p->getId()){
                    if($c->getPatient()->getId() == $p->getId()){
                        $consultation = count($consultations);
                        return $this->render('consultation/index.html.twig', compact('consultations'));
                    }
                }
            }
        }

        return $this->render('error.html.twig', compact('consultations'));
    }


    /**
     * @Route("/medecin/consultation", name="consultation_medecin")
     */
    public function getConsultationByMedecin(MedecinRepository $medecinrepos, ConsultationRepository $consultationrepos)
    {
        $medecin = $medecinrepos->findBy(['statut'=>true]);
        // dd($medecin);
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $consultations = $consultationrepos->findByMedecin($user);
        // dd($consultations);

        foreach($medecin as $m){
            foreach($consultations as $c){
                if($user == $m->getId()){
                    if($c->getMedecin()->getId() == $m->getId()){
                        return $this->render('consultation/index.html.twig', compact('consultations'));
                    }
                }
            }
        }

        return $this->render('error.html.twig', compact('consultations'));
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
            return $this->render('succes.html.twig');
            return $this->render('consultation/index.html.twig', [
                'controller_name' => 'ConsultationController'
            ]);
        }
        return $this->render('consultation/create_consultation.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
