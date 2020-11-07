<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\HopitalRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RendezVousController extends AbstractController
{
    /**
     * @Route("/rendezvous/index", name="rendez_vous_medecin")
     */
    public function getRendezVous(RendezVousRepository $rdvrepos)
    {
        $rdv = $rdvrepos->findBy(['etat'=>'encours']);
        // dd($rdv);
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }


       /**
     * @Route("rendezvous/index", name="rendez_vous_hopital")
     */
    public function getRendezVousByHopital(RendezVousRepository $rdvrepos, HopitalRepository $hopitalrepos, $id)
    {
        $hopital = $hopitalrepos->find($id);
        $rdv = $rdvrepos->findBy(['etat'=>'encours']);
        // dd($hopital);
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }


    /**
     * @Route("/patient/rendezvous", name="rendez_vous_patient")
     */
    public function getRendezVousByPatient(RendezVousRepository $rdvrepos, PatientRepository $patientrepos)
    {
        $patients = $patientrepos->findBy(['statut'=>true]);
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $rendezVouses = $rdvrepos->findByUser($user);
        // dd($rendezVouses);
        foreach($rendezVouses as $rdv){
            if($user == $rdv->getUser()->getId()){
                return $this->render('rendez_vous/index.html.twig', compact('rendezVouses'));
            }
        }
        return $this->render('error.html.twig');
    }



     /**
     * @Route("/rendezvous/create", name="rendez_vous_create")
     */
    public function createRendezVous(Request $request,SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        
        $rendezvous = new RendezVous();

        $form = $this->createForm(RendezVousType::class, $rendezvous);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $rendezvous = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $rendezvous -> setEtat("encours");
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $rendezvous -> setUser($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($rendezvous);
            $manager->flush();
            return $this->render('succes.html.twig');
            return $this->render('rendez_vous/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => $rendezvous->getLibelle()
            ]);
        }
        return $this->render('rendez_vous/create_rendez_vous.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}
