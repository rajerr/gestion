<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Form\SuiviType;
use App\Repository\PatientRepository;
use App\Repository\MedecinRepository;
use App\Repository\ConsultationRepository;
use App\Repository\SuiviRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\DateTimeFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SuiviController extends AbstractController
{
    /**
     * @Route("/suivi", name="suivi_index")
     */
    public function index()
    {
        return $this->render('suivi/index.html.twig', [
            'controller_name' => 'SuiviController',
        ]);
    }

    /**
     * @Route("/patient/suivi", name="suivi_patient")
     */
    public function suiviPatient(PatientRepository $patientrepos, SuiviRepository $suivirepos,ConsultationRepository $consultationrepos)
    {
        $patients = $patientrepos->findBy(['statut'=>true]);
        //dd($patient);
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $consultations  = $consultationrepos->findByPatient($user);
        $suivis = $suivirepos->findByConsultation($consultations);
         //dd($consultations);
         foreach($patients as $p){
             foreach($consultations as $c){
                 foreach($suivis as $s){
                     if($user == $p->getId()){
                         if($c->getPatient()->getId() == $user){
                             if($s->getConsultation()->getId() == $c->getId()){
                                $date = new DateTimeFormat('y-m-d h:i:s');
                                $date->format('Y-m-d H:i:s');
                                return $this->render('suivi/index.html.twig', compact('suivis'));
                             }
                         }
                     }
                 }
             }
         }
         return $this->render('error.html.twig', compact('consultations'));
    }

    /**
     * @Route("/medecin/suivi", name="suivi_medecin")
     */
    public function suiviMedecin(MedecinRepository $medecinrepos, SuiviRepository $suivirepos,ConsultationRepository $consultationrepos)
    {
        $medecins = $medecinrepos->findBy(['statut'=>true]);
        //dd($Medecin);
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $consultations  = $consultationrepos->findByMedecin($user);
        $suivis = $suivirepos->findByConsultation($consultations);
         //dd($consultations);
         foreach($medecins as $p){
             foreach($consultations as $c){
                 foreach($suivis as $s){
                     if($user == $p->getId()){
                         if($c->getMedecin()->getId() == $user){
                             if($s->getConsultation()->getId() == $c->getId()){
                                $date = $suivis->getDateprise();
                                $date = new DateTime('y-m-d h:i:s');
                                return $this->render('suivi/index.html.twig', compact('suivis'));
                             }
                         }
                     }
                 }
             }
         }
         return $this->render('error.html.twig', compact('consultations'));
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
            return $this->render('succes.html.twig');
            return $this->render('suivi/index.html.twig', [
                'controller_name' => 'suiviController'
            ]);
        }
        return $this->render('suivi/create_suivi.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
